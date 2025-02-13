<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use Exception;
use App\Models\Promotion;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PromotionGallery;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('promotion.view')) {
            abort(403, 'Unauthorized action.');
        }

        $promotions = Promotion::when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                      });
            });
        })
        ->when($request->discount_type, function ($query, $discountType) {
            $query->where('discount_type', $discountType);
        })
        ->with('promotiongallery')
        ->latest('id')
        ->paginate(10);

        return view('backends.promotion.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $language = BusinessSetting::where('type', 'language')->first();
        $brands = Brand::with('products')->get();
        $products = Product::where('status', 1)->orderBy('name')->get();
        $language = $language->value ?? null;
        $default_lang = 'en';
        $default_lang = json_decode($language, true)[0]['code'];
        return view('backends.promotion.create', compact('brands', 'products', 'language', 'default_lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if (is_null($request->title[array_search('en', $request->lang)])) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'title',
                    'title field is required!'
                );
            });
        }

        if (is_null($request->description[array_search('en', $request->lang)])) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'description',
                    'description field is required!'
                );
            });
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            // dd($request->all());
            $promotion = new Promotion();
            $promotion->title = $request->title[array_search('en', $request->lang)];
            $promotion->description = $request->description[array_search('en', $request->lang)];
            $promotion->discount_type = $request->discount_type;
            $promotion->percent = $request->percent;
            $promotion->amount = $request->amount;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->promotion_type = $request->promotion_type;

            // if ($request->filled('banners')) {
            //     $promotion->banner = $request->banners;
            //     $directory = public_path('uploads/promotions');
            //     if (!File::exists($directory)) {
            //         File::makeDirectory($directory, 0777, true);
            //     }

            //     $banner = File::move(public_path('/uploads/temp/' . $request->banners), public_path('uploads/promotions/' . $request->banners));
            // }
            $promotion->save();

            $promotionid = $promotion->id;
            $promotion_gallery = new PromotionGallery();
            $promotion_gallery->promotion_id = $promotionid;
            if ($request->filled('image_names')) {
                $imageDetails = json_decode($request->input('image_names'), true);
                $promotion_data = [];
                foreach ($imageDetails as $detail) {
                    $directory = public_path('uploads/promotions');
                    if (!\File::exists($directory)) {
                        \File::makeDirectory($directory, 0777, true);
                    }
                    $moved_image = \File::move(public_path('uploads/temp/' . $detail), $directory . '/' . $detail);
                    $promotion_data[] = $detail;
                    $promotion_gallery->images = $promotion_data;
                    $promotion_gallery->save();
                }
            }

            if ($request->filled('products')) {
                $productIds = $request->products;
                $promotion->products()->attach($productIds);
            }

            if ($request->filled('brands')) {
                $brandIds = $request->brands;
                $promotion->brands()->attach($brandIds);
            }


            $data = [];
            foreach ($request->lang as $index => $key) {
                if ($request->title[$index] && $key != 'en') {
                    array_push($data, array(
                        'translationable_type' => 'App\Models\Promotion',
                        'translationable_id' => $promotion->id,
                        'locale' => $key,
                        'key' => 'title',
                        'value' => $request->title[$index],
                    ));
                }
            }

            Translation::insert($data);

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        return redirect()->route('admin.promotion.index')->with($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $promotion = Promotion::withoutGlobalScopes()->with('translations')->findOrFail($id);
        $promotion = Promotion::withoutGlobalScopes()->with('translations', 'products', 'brands', 'promotiongallery')->findOrFail($id);

        $brands = Brand::with('products')->get();
        $brand_promotionId = [];
        if ($promotion->brands()->get() && $promotion->brands()->get()->count() > 0) {
            $brand_promotionId = $promotion->brands()->get()->pluck('id')->toArray();
        }
        // dd($brand_promotionId);

        $products = Product::where('status', 1)->orderBy('name')->get();
        $product_promotionId = [];
        if ($promotion->products()->get() && $promotion->products()->get()->count() > 0) {
            $product_promotionId = $promotion->products()->get()->pluck('id')->toArray();
        }
        // dd($product_promotionId);

        $language = BusinessSetting::where('type', 'language')->first();
        $language = $language->value ?? null;
        $default_lang = 'en';
        $default_lang = json_decode($language, true)[0]['code'];
        return view('backends.promotion.edit', compact('brands', 'products', 'brand_promotionId', 'product_promotionId', 'promotion', 'language', 'default_lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if (is_null($request->title[array_search('en', $request->lang)])) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'title',
                    'title field is required!'
                );
            });
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $promotion =  Promotion::findOrFail($id);
            $promotion->title = $request->title[array_search('en', $request->lang)];
            $promotion->discount_type = $request->discount_type;
            $promotion->percent = $request->percent;
            $promotion->amount = $request->amount;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->promotion_type = $request->promotion_type;

            // Update header banner
            // if ($request->hasFile('banner')) {
            //     if ($promotion->banner && file_exists(public_path('uploads/promotions/' . $promotion->banner))) {
            //         unlink(public_path('uploads/promotions/' . $promotion->banner));
            //     }

            //     $promotion->banner = ImageManager::update('uploads/promotions/', null, $request->banner);
            // }

            $promotion->save();

            $promotion_gallery = PromotionGallery::where('promotion_id',$promotion->id)->first();
            $promotiongallery = $promotion_gallery->images??[];
            $imageNameToUpdate = $request->input('image_names');
            $newImage = json_decode($imageNameToUpdate, true);
            $promotion_data = [];
            if (is_array($newImage)) {
                foreach ($newImage as $detail) {
                    $directory = public_path('uploads/promotions');
                    if (!\File::exists($directory)) {
                        \File::makeDirectory($directory, 0777, true);
                    }
                    $moved_image = \File::move(public_path('uploads/temp/' . $detail), $directory . '/' . $detail);
                    $promotion_data[] = $detail;
                }
            }
            $merge = array_merge($promotiongallery, $promotion_data);
            if ($promotion_gallery) {
                $promotion_gallery->images = $merge;
                $promotion_gallery->save();
            } else {
                $promotion_gallery = new PromotionGallery();
                $promotion_gallery->promotion_id = $promotion->id;
                $promotion_gallery->images = $merge;
                $promotion_gallery->save();
            }

            if ($request->promotion_type === 'brand') {
                // Sync brands and clear products
                if ($request->filled('brands')) {
                    $brandIds = $request->brands;
                    $promotion->brands()->sync($brandIds);
                } else {
                    $promotion->brands()->sync([]);
                }
                // Clear products
                $promotion->products()->sync([]);

            } elseif ($request->promotion_type === 'product') {
                // Sync products and clear brands
                if ($request->filled('products')) {
                    $productIds = $request->products;
                    $promotion->products()->sync($productIds);
                } else {
                    $promotion->products()->sync([]);
                }
                // Clear brands
                $promotion->brands()->sync([]);
            }

            foreach ($request->lang as $index => $key) {
                if (isset($request->title[$index]) && $key != 'en') {
                    Translation::updateOrInsert(
                        ['translationable_type' => 'App\Models\Promotion',
                            'translationable_id' => $promotion->id,
                            'locale' => $key,
                            'key' => 'title'],
                        ['value' => $request->title[$index]]
                    );
                }
            }

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        return redirect()->route('admin.promotion.index')->with($output);
    }

    /**
     * Function to handle image update process
     *
     * @param $request
     * @param $promotion
     * @param $imageFieldName
     */
    function updateImage($request, $promotion, $imageFieldName)
    {
        // Check if a new image is uploaded
        if ($request->hasFile($imageFieldName)) {
            // Delete the old image if it exists
            if ($promotion->{$imageFieldName}) {
                $oldImagePath = public_path('uploads/promotions/' . $promotion->{$imageFieldName});

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image file
                }
            }

            // Upload and save the new image
            $image = $request->file($imageFieldName);

            // Generate a unique filename based on current date and unique identifier
            $imageName = now()->format('Y-m-d') . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to the promotions directory
            $image->move(public_path('uploads/promotions'), $imageName);

            // Update the image attribute of the promotion model
            $promotion->{$imageFieldName} = $imageName;

            // Save the updated promotion model
            $promotion->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $promotion = Promotion::findOrFail($id);
            $translation = Translation::where('translationable_type', 'App\Models\Promotion')
                ->where('translationable_id', $promotion->id);
            $translation->delete();
            $promotion->delete();

            $promotions = Promotion::latest('id')->paginate(10);
            $view = view('backends.promotion._table', compact('promotions'))->render();

            DB::commit();
            $output = [
                'status' => 1,
                'view' => $view,
                'msg' => __('Deleted successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'status' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return response()->json($output);
    }
    public function updateStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            $promotion = Promotion::findOrFail($request->id);
            $promotion->status = $promotion->status == 1 ? 0 : 1;
            $promotion->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }

    public function deletePromotionGallery(Request $request)
    {
        $promotionGallery = PromotionGallery::where('promotion_id', $request->promotion_id)->first();
        if ($promotionGallery) {
            $imageNameToDelete = $request->input('name');
            $images = $promotionGallery->images;
            $imageExists = false;
            foreach ($images as $image) {
                if ($image === $imageNameToDelete) {
                    $imageExists = true;
                    break;
                }
            }
            if ($imageExists) {
                $newImages = array_filter($images, function ($image) use ($imageNameToDelete) {
                    return $image !== $imageNameToDelete;
                });
                $imagePath = public_path('uploads/promotions/' . $imageNameToDelete);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $promotionGallery->images = array_values($newImages);
                $promotionGallery->save();

                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }
}
