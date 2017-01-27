@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
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
                        <input type="hidden" name="profuser" value="admin"/>
                        {{ csrf_field() }}
                   </form>
                </div>
            </div>
        </div>
    </div>
    @if($posts != null)
        @foreach($posts as $post)
            @foreach(Auth::user()->follow as $follow)
                @if(Auth::user()->id == $post->user_id || $follow->profile_id == $post->profile_id)
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="panel-default">
                                <div class="panel-heading">
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
                                            <h4 class="media-heading">
                                                {{ $post->user->name }}
                                            </h4>        
                                        </a>
                                        @if($post->user->profile->id != $post->profile_id)
                                            with <span class="glyphicon glyphicon-share-alt"></span>
                                            @foreach($users as $user)
                                                @if($user->profile->id == $post->profile_id)
                                                    <a href="{{ route('profile',['id' => $user->id]) }}">{{ $user->name }}</a>
                                                @endif
                                            @endforeach
                                        @endif
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
                                                <a href="{{ $img->link }}" data-lightbox="{{ $img->link }}">
                                                    <img src="{{ $img->link }}" class="img-responsive" alt="{{ $post->user->name }}">
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 hidden-xs">
                            <a href="#">
                                <h3>
                                    <span class="label label-default">
                                        <span class="glyphicon glyphicon-heart"></span>
                                        <span class="badge">42</span>
                                    </span>    
                                </h3>
                                    
                            </a>
                            <a href="#">
                                <h3>
                                    <span class="label label-default">
                                        <span class="glyphicon glyphicon-comment"></span>
                                        <span class="badge">42</span>
                                    </span>
                                </h3>
                            </a>
                            <a href="{{ route('repost', [ 'id' => $post->id ]) }}">
                                <h3>
                                    <span class="label label-default">
                                        <span class="glyphicon glyphicon-retweet"></span>
                                        <span class="badge">42</span>
                                    </span>
                                </h3>
                            </a>
                        </div>
                        <div class="col-xs-5">
                            <div class="panel-default">
                                <div class="panel-heading">
                                    <form class="form-inline" method="POST" action="{{ route('comment') }}" >
                                      <div class="form-group">
                                        {{ csrf_field() }}
                                        <input class="form-control" name="comment" rows="3" placeholder="Comment">
                                        <button type="submit" class="btn btn-default">Post</button>
                                        <input type="hidden" name="postid" value="{{ $post->id }}"/>
                                      </div>
                                    </form>
                                </div>
                                <div class="panel-body">
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
                    </div>
                <div class="clearfix visible-xs-block visible-lg-block"></div>
                <br>
                <?php break; ?>
                @endif
            @endforeach
        @endforeach
    @endif
</div>
@endsection
