<?php

namespace Modules\Icommercecheckmo\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommercecheckmo\Entities\IcommerceCheckmo;
use Modules\Icommercecheckmo\Http\Requests\CreateIcommerceCheckmoRequest;
use Modules\Icommercecheckmo\Http\Requests\UpdateIcommerceCheckmoRequest;
use Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class IcommerceCheckmoController extends AdminBaseController
{
    /**
     * @var IcommerceCheckmoRepository
     */
    private $icommercecheckmo;
    private $paymentMethod;

    public function __construct(IcommerceCheckmoRepository $icommercecheckmo)
    {
        parent::__construct();

        $this->icommercecheckmo = $icommercecheckmo;
        $this->paymentMethod = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$icommercecheckmos = $this->icommercecheckmo->all();

        return view('icommercecheckmo::admin.icommercecheckmos.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommercecheckmo::admin.icommercecheckmos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIcommerceCheckmoRequest $request
     * @return Response
     */
    public function store(CreateIcommerceCheckmoRequest $request)
    {
        $this->icommercecheckmo->create($request->all());

        return redirect()->route('admin.icommercecheckmo.icommercecheckmo.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercecheckmo::icommercecheckmos.title.icommercecheckmos')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  IcommerceCheckmo $icommercecheckmo
     * @return Response
     */
    public function edit(IcommerceCheckmo $icommercecheckmo)
    {
        return view('icommercecheckmo::admin.icommercecheckmos.edit', compact('icommercecheckmo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceCheckmo $icommercecheckmo
     * @param  UpdateIcommerceCheckmoRequest $request
     * @return Response
     */
    public function update($id, UpdateIcommerceCheckmoRequest $request)
    {

        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);
        
        //Add status request
        if($request->status=='on')
            $request['status'] = "1";
        else
            $request['status'] = "0";

        //Get data
        $data = $request->all();
        $requestimage = $data['mainimage'];

        // Delete attributes
        unset($data['mainimage']);

        // Image
        if(($requestimage==NULL) || (!empty($requestimage)) ){
            $requestimage = $this->saveImage($requestimage,"assets/icommercecheckmo/1.jpg");
        }
        $options['mainimage'] = $requestimage;

        // Extra data in Options
        $data['options'] = json_encode($options);

       
        $paymentMethod->update($data);

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecheckmo::icommercecheckmos.single')]));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IcommerceCheckmo $icommercecheckmo
     * @return Response
     */
    public function destroy(IcommerceCheckmo $icommercecheckmo)
    {
        $this->icommercecheckmo->destroy($icommercecheckmo);

        return redirect()->route('admin.icommercecheckmo.icommercecheckmo.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercecheckmo::icommercecheckmos.title.icommercecheckmos')]));
    }

    /**
     * Save Image
     *
     * @param  
     * @return 
     */
    public function saveImage($value,$destination_path)
    {

        $disk = "publicmedia";

        //Defined return.
        if(ends_with($value,'.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing

            $image->resize(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if(config('asgard.iblog.config.watermark.activated')){
                $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg','80'));


            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg','_mediumThumb.jpg',$destination_path),
                $image->fit(config('asgard.iblog.config.mediumthumbsize.width'),config('asgard.iblog.config.mediumthumbsize.height'))->stream('jpg','80')
            );

            \Storage::disk($disk)->put(
                str_replace('.jpg','_smallThumb.jpg',$destination_path),
                $image->fit(config('asgard.iblog.config.smallthumbsize.width'),config('asgard.iblog.config.smallthumbsize.height'))->stream('jpg','80')
            );

            // 3. Return the path
            return $destination_path;
        }

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }
    }


}
