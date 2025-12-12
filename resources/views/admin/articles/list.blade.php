@extends('admin.index')

@section('styles')
    @include('components.styles-DataTable')
@endsection

@section('scripts-bottom')
    @include('components.scripts-DataTable')

    <script>
      $(function () {
          $('#table-admin-articles').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "order": []
          });
      });

      
    </script>
@endsection

@section('contentAdmin')
 
<section>
    <h1>Article List</h1>
    <hr>
    <!-- <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div> -->
    <div class="top-link-holder">
        <a href="{{ url('admin/add-article') }}" class="btn btn-primary">
            ADD ARTICLE
        </a>
    </div>
    <div class="table-responsive mt-60 mb-60">

    <table id="table-admin-articles" class="table table-white table-hover">
        <thead class="thead-light">
        <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Carousel</th>
        <th>Date</th>
        <th>Actions</th>
        </tr>
        </thead>
        <tbody>
    @foreach($articles as $article)
        <tr>
            <td>{{ $article->name }}</td>
            <td>{{ $article->published }}</td>
            <td>@if($article->on_spotlight == 1) Yes @else No @endif</td>
            <td>
                <div hidden>{{ $article->date }}</div>
                {{ \Carbon\Carbon::parse($article->date)->format('F d, Y') }}
            </td>
            <td>
                @admineditor
                <a href="{{  route('admin.edit-article', ['id' => $article->id]) }}" title="Edit article">
                    <i class="fa fa-edit"></i>
                </a>
                @endadmineditor
                @if($article->published == 'published')
                    <a href="{{ route('articles.view', ['slug' => $article->latestSlug->value]) }}" title="Open Link" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-external-link"></i>
                    </a>
                @endif
                
                <!-- <a href="" title="Status">
                    <i class="fa fa-eye"></i>
                    {{-- Toggle when article is not yet published
                        <i class="fa fa-eye-slash"></i>  --}}
                </a> -->
                
                <!-- <a href="" title="Delete article">
                    <i class="fa fa-trash"></i>
                </a> -->
            </td>
        </tr>
    @endforeach
        <!-- <tfoot>
        <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        </tr>
        </tfoot> -->
    </table>



        <!-- <table class="table table-bordered table-hover article-list">
            <thead>
                <tr>
                    <th width="60%">Title</td>
                    <th width="20%">Date Created</td>
                    <th width="20%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Sample article title
                    </td>
                    <td>
                        Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{  url('admin/edit-article') }}" title="Edit article">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="" title="Status">
                            <i class="fa fa-eye"></i>
                            {{-- Toggle when article is not yet published
                                <i class="fa fa-eye-slash"></i>  --}}
                        </a>
                        <a href="" title="Open link">
                            <i class="fa fa-link"></i>
                        </a>
                        <a href="" title="Delete article">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table> -->
    </div>
</section>

@endsection