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

    public function __construct(IcommerceCheckmoRepository $icommercecheckmo)
    {
        parent::__construct();

        $this->icommercecheckmo = $icommercecheckmo;
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
    public function update(IcommerceCheckmo $icommercecheckmo, UpdateIcommerceCheckmoRequest $request)
    {
        $this->icommercecheckmo->update($icommercecheckmo, $request->all());

        return redirect()->route('admin.icommercecheckmo.icommercecheckmo.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecheckmo::icommercecheckmos.title.icommercecheckmos')]));
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
}
