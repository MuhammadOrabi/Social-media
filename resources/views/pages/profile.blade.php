@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($user->profile != null)
                        @if($user->profile->img != null)
                            <a href="{{ $user->profile->img->link }}" data-lightbox="{{ $user->profile->img->link }}" class="center thumbnail">
                                <img src="{{ $user->profile->img->link }}" class="img-rounded center-block"  alt="" width="304" height="304">
                            </a>
                            <a href="{{ route('profile',['id' => $user->id]) }}"><h3>{{ $user->name }}</h3></a>
                        @endif
                    @else
                        <a class="center" href="{{ route('profile',['id' => $user->id]) }}"><h3>{{ $user->name }}</h3></a>
                    @endif
                    @if(Auth::user()->id != $user->id)
                        @if($follow)
                            <form method="POST" action="{{ route('unfollow') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="profile_id" value="{{ $user->profile->id }}"/>
                                <button class="btn btn-default" style="float: right;" type="submit"><span class="glyphicon glyphicon-ok-circle"></span> Following</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="profile_id" value="{{ $user->profile->id }}"/>
                                <input class="btn btn-default" style="float: right;" type="submit" value="Follow"/>
                            </form>
                        @endif
                    @endif
                </div>
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#time" aria-controls="time" role="tab" data-toggle="tab">Timeline</a></li>
                        <li role="presentation"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Basic Info</a></li>
                        <li role="presentation"><a href="#pics" aria-controls="pics" role="tab" data-toggle="tab">Photos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="info">
                            @if(Auth::user()->id == $user->id)
                                <div class="panel-heading">    
                                    <ol class="breadcrumb">
                                        <li><a href="" onclick="updateinfo()"><span class="glyphicon glyphicon-picture"></span> update Info </a></li>
                                    </ol>
                                </div>
                            @endif
                            <div class="panel-body">
                                <section class="text-center">
                                @if($user->info != null)
                                    <h3> About</h3><p class="lead"><i>{{ $user->info->about }}</i></p>
                                    <br>
                                    <h3> Birthday</h3><p class="lead"><i>{{ $user->info->date }}</i></p>
                                    <br>
                                    <h3> Education</h3><p class="lead"><i>{{ $user->info->edu }}</i></p>
                                    <br>
                                @endif
                                <h3> Contact info</h3><p class="lead"><i>{{ $user->email }}</i></p>
                                </section>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="pics">
                            @if(Auth::user()->id == $user->id)
                                <div class="panel-heading">    
                                    <ol class="breadcrumb">
                                        <li><a href="" onclick="update()"><span class="glyphicon glyphicon-picture"></span> update profile picture </a></li>
                                        <li><a href="" onclick="uploadpic()"><span class="glyphicon glyphicon-picture"></span> upload profile picture </a></li>
                                    </ol>
                                </div>
                            @endif
                            <div class="panel-body">
                                <div id="thumbs">
                                    @if($user->imgs != null)
                                        @foreach($user->imgs as $img)
                                            <a href="{{ $img->link }}" data-lightbox="{{ $img->link }}"><img src="{{ $img->link }}" class="img-thumbnail" alt="{{ $user->name }}" width="180" height="180"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="time">
                            <div class="panel-body">
                                <div class="panel panel-default">
                                    <div  class=" panel-heading">
                                        <form method="POST" action="{{ route('post') }}" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-5 col-md-offset-3">
                                                        <textarea class="form-control" name="post" rows="3" placeholder="what`s on your mind..?"></textarea>
                                                    </div>
                                                    <label for="file"><span class="glyphicon glyphicon-picture"></span> <strong>Add image</strong></label>
                                                    <input  class="inputfile" type="file" name="img" id="file">
                                                    <br>
                                                    <input class ="btn btn-primary" type="submit" value="Post"/>
                                                </div>
                                            </div>
                                            <input type="hidden" name="profuser" value="{{ $user->profile->id }}"/>
                                            {{ csrf_field() }}
                                       </form>
                                    </div>
                                    <div class="panel-body col-md-7 col-md-offset-2">
                                        @if($posts != null)
                                            @foreach($posts as $post)
                                                <blockquote class="post" data-post="{{ $post->id }}">
                                                    <ul class="nav navbar-nav navbar-right">
                                                        <div class="inter">
                                                            <li class="dropdown">
                                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-option-vertical"></span></a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    @if(Auth::user()->id == $post->user->id)
                                                                        <li><a href="" id="edit"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
                                                                        <li><a href="{{ route('delete',['id' => $post->id]) }}" ><span class="glyphicon glyphicon-trash"></span>  Delete</a></li>
                                                                    @else
                                                                        <li><a href=""><span class="glyphicon glyphicon-ban-circle"></span> report</a></li>
                                                                    @endif
                                                                </ul>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                    <div class="media">
                                                      <div class="media-left media-middle">
                                                        @if($post->user->profile)
                                                            @if($post->user->profile->img)
                                                                <a href="{{ route('profile',['id' => $post->user->id]) }}">
                                                                  <img src="{{ $post->user->profile->img->link }}" class="img-rounded"  alt="{{ $post->user->name }}" width="80" height="80">
                                                                </a>
                                                            @endif
                                                        @endif
                                                      </div>
                                                      <div class="media-body">
                                                        <a href="{{ route('profile',['id' => $post->user->id]) }}">
                                                            <h4 class="media-heading">{{ $post->user->name }}</h4>
                                                        </a>
                                                        <footer>{{ $post->created_at }} <cite title="Source Title"></cite></footer>
                                                        <br>
                                                        <br>
                                                      </div>
                                                    </div>
                                                    @if($post->text != null)
                                                            <p class="lead text-center">{{ $post['text'] }}</p>
                                                        @endif
                                                        
                                                      @if($post->imgs != null)
                                                            <div id="thumbs">
                                                                @foreach($post->imgs as $img)
                                                                    <a href="{{ $img->link }}" data-lightbox="{{ $img->link }}"><img src="{{ $img->link }}" class="img-rounded" alt="{{ $user->name }}" width="220" height="220"></a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                </blockquote>
                                                    <ol class="breadcrumb" role="tablist">
                                                        <li><a href="#"><span class="glyphicon glyphicon-thumbs-up"></span> Like </a></li>
                                                        <li role="presentation"><a href="#comm{{$post->id}}" aria-controls="comm{{$post->id}}" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span> Comment </a></li>
                                                        <li><a href="{{ route('repost', [ 'id' => $post->id ]) }}" ><span class="glyphicon glyphicon-retweet"></span> Repost </a></li>
                                                    </ol>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane" id="comm{{$post->id}}">
                                                            <div class="well">
                                                                <form class="form-inline" method="POST" action="{{ route('comment') }}" >
                                                                  <div class="form-group">
                                                                    {{ csrf_field() }}
                                                                    <textarea class="form-control" name="comment" rows="1" placeholder="Comment"></textarea>
                                                                    <button type="submit" class="btn btn-default">Post</button>
                                                                    <input type="hidden" name="postid" value="{{ $post->id }}"/>
                                                                  </div>
                                                                </form>
                                                                <hr>
                                                                @if($post->comments != null)
                                                                    @foreach($post->comments as $comment)
                                                                        <blockquote>
                                                                            <ul class="nav navbar-nav navbar-right">
                                                                                <li class="dropdown">
                                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-option-vertical"></span></a>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        @if(Auth::user()->id == $comment->user->id)
                                                                                            <li><a href=""><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
                                                                                            <li><a href=""><span class="glyphicon glyphicon-trash"></span>  Delete</a></li>
                                                                                        @else
                                                                                            <li><a href=""><span class="glyphicon glyphicon-ban-circle"></span> report</a></li>
                                                                                        @endif
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                            <div class="media">
                                                                              <div class="media-left media-middle">
                                                                                @if($post->user->profile)
                                                                                    @if($post->user->profile->img)
                                                                                        <a href="{{ route('profile',['id' => $comment->user->id]) }}">
                                                                                          <img src="{{ $comment->user->profile->img->link }}" class="img-rounded"  alt="{{ $comment->user->name }}" width="44" height="44">
                                                                                        </a>
                                                                                    @endif
                                                                                @endif
                                                                              </div>
                                                                              <div class="media-body">
                                                                                <a href="{{ route('profile',['id' => $comment->user->id]) }}">
                                                                                    <h4 class="media-heading">{{ $comment->user->name }}</h4>
                                                                                </a>
                                                                              </div>
                                                                            </div>
                                                                            <p class="lead text-center">{{ $comment->com }}</p>
                                                                            <footer><em>{{ $comment->created_at }}</em></footer>
                                                                        </blockquote>
                                                
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="prof">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Profile Picture</h4>
      </div>
      <div class="modal-body">
        <div id="thumbs">
            <strong>your pictures:</strong><hr>
            @foreach($user->imgs as $img)
                <a onclick="confirm({{ $img }})"><img src="{{ $img->link }}" class="img-rounded" alt="{{ $user->name }}" width="80" height="80"></a>
            @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="conf">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Profile Picture</h4>
      </div>
      <div class="modal-body">
        <strong>Create profile picture:</strong><hr>
        <img id="img-link" width="480" height="480">
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ route('prof-pic') }}">
            <input type="hidden" name="id" id="img-id"  value="">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="upload">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upload Profile Picture</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('info') }}" enctype="multipart/form-data"> 
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label"for="fileToUpload">Profile Picture</label>
                    <input class="btn" type="file" name="img" id="fileToUpload">
                    {{ csrf_field() }}
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="updateinfo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Info</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('info') }}" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group col-md-6">
                    <textarea class="form-control" rows="9"  name="txt" placeholder="Say something about you...."></textarea>  
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                   <input type="text" name="date"  class="form-control"  placeholder="Birthday Date..(ex: 00-00-0000 Or 00 july 00...)">    
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                   <input type="text" name="edu" id="title" class="form-control" placeholder="your education....">    
                </div>
            </div>
            {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    /*global $*/
    function uploadpic() 
    {
        console.log("done");
        event.preventDefault();
        $('#upload').modal();
    }
    
    function updateinfo() 
    {
        event.preventDefault();
        $('#updateinfo').modal();
    }

</script>
@endsection
