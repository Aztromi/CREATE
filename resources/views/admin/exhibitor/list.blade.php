@extends('admin.index')
@section('styles')
    @include('components.styles-DataTable')
    <link rel="stylesheet" href="{{ asset('css/admin/exhibitor/list.css?ver='.time()) }}">
@endsection



@section('contentAdmin')

    <!-- Full-screen modal -->
    <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                </div>
            </div>
        </div>
    </div>



    <section>
        <div class="row">
            <div class="col-12">
                <h1>Exhibitors</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="table-responsive mt-5 mb-5">
                    <table class="table table-white table-hover" id="exhibitor-list">
                        <thead class="thead-light">
                            <tr>
                                <th>Exhibitor</td>
                                <th>Status</td>
                                <th>Date Registered</td>
                                <th>Action/s</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        
    </section>



@endsection


@section('scripts-bottom')

    @include('components.scripts-DataTable')
    
    <script>
        function presets()
        {
            getData("{{ route('admin.exhibitors.getExhibitorList') }}");
        }
    </script>

    <script src="{{ asset('js/admin/exhibitor/list.js?ver='.time()) }}"></script>

@endsection