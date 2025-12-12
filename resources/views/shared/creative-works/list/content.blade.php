<section>

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

    <div class="card col-lg-12 col-xl-10 mx-auto">
        <div class="card-body">
            <div class="container" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col mt-4 mb-4 text-center">
                        <h1>CREATIVE WORKS</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{ $addLink }}" class="btn btn-primary">Add New Creative Work</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-5 mb-5">
                            <table class="table table-white table-hover w-100" id="works-list">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Title</td>
                                        @if($uType == 'admin')<th>Creative</th>@endif
                                        <th>Status</td>
                                        <th>Date Published</td>
                                        <th>Date Updated</td>
                                        <th>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        @if($uType == 'admin')<td>-</td>@endif
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
                



            </div>
        </div>
    </div>

    
</section>