@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Settings</h3>
                </div>
                <div class="panel-group text-center" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Profile
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form method="post" action="{{ route('info') }}" enctype="multipart/form-data"> 
                                    <label for="fileToUpload">Profile Picture</label>
                                    <div class="row">
                                        <div class="form-group col-sm-offset-4">
                                            <input class="btn" type="file" name="img" id="fileToUpload">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-offset-1 col-sm-10">
                                            <textarea class="form-control" rows="9"  name="txt" placeholder="Say something about yourself...."></textarea>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-sm-offset-3">
                                           <input type="text" name="date"  class="form-control"  placeholder="Birthday Date..(ex: 00-00-0000 Or 00 july 00...)">    
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4 col-sm-offset-4">
                                           <input type="text" name="edu" id="title" class="form-control" placeholder="your education....">    
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-md-offset-4">
                                           <button type="submit" name="submit" class="btn btn-primary">Save</button>  
                                    </div>
                                    {{ csrf_field() }}
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Collapsible Group Item #2
                                </a>
                            </h4>
                        </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                        </div>
                    </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Collapsible Group Item #3
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop