@php
    $configuration = icommercecheckmo_get_configuration();
    $options = array('required' =>'required');
    
    if($configuration==NULL){
        $cStatus = 0;
        $entity = icommercecheckmo_get_entity();
    }else{
        $cStatus = $configuration->status;
        $entity = $configuration;
    }

    $status = icommerce_get_status();
    $formID = uniqid("form_id");
    
@endphp

{!! Form::open(['route' => ['admin.icommercecheckmo.checkmoconfig.update'], 'method' => 'put','name' => $formID]) !!}

<div class="col-xs-12 col-sm-9">

    @include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
    
    {!! Form::normalInput('description', trans('icommercecheckmo::checkmoconfigs.table.description'), $errors,$configuration,$options) !!}

    <div class="form-group">
        <div>
            <label class="checkbox-inline">
                <input name="status" type="checkbox" @if($cStatus==1) checked @endif>{{trans('icommercecheckmo::checkmoconfigs.table.activate')}}
            </label>
        </div>   
    </div>

</div>

<div class="col-sm-3">

    @include('icommercecheckmo::admin.checkmoconfigs.partials.featured-img',['crop' => 0,'name' => 'mainimage','action' => 'create'])

</div>
    
    
 <div class="clearfix"></div>   

    <div class="box-footer">
    <button type="submit" class="btn btn-primary btn-flat">{{ trans('icommercecheckmo::checkmoconfigs.button.save configuration') }}</button>
    </div>



{!! Form::close() !!}