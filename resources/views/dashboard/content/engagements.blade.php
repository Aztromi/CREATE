@extends('dashboard.index')

@section('userDashboard')
 
<section>
    <h1>Engagements</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="row mb-60">
            <div class="mb-20">
                <h2>Profile</h2>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        35
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Followers
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        324
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Profile Visits
                    </p>
                </div>
            </div>
        </div>
        <div class="row mb-20">
            <div class="mt-40 mb-20">
                <h2>Works</h2>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        12
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Published Works
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        34
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Bookmarks
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        109
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Pageviews
                    </p>
                </div>
            </div>
        </div>
        <div class="row mt-50 mb-60">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="40%">Items</td>
                                <th width="30%">Category</td>
                                <th width="10%">Bookmarks</td>
                                <th width="10%">Pageviews</td>
                                <th width="10%">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <b>Family Portrait</b>
                                    <br>Date posted: September 7, 2021
                                </td>
                                <td>
                                    Article
                                </td>
                                <td>
                                    3
                                </td>
                                <td>
                                    37
                                </td>
                                <td class="action-holder">
                                    <a href="" title="Open link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>In Her Eyes</b>
                                    <br>Date posted: January 8, 2021
                                </td>
                                <td>
                                    Article
                                </td>
                                <td>
                                    11
                                </td>
                                <td>
                                    21
                                </td>
                                <td class="action-holder">
                                    <a href="" title="Open link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>3AM</b>
                                    <br>Date posted: October 15, 2020
                                </td>
                                <td>
                                    Article
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    12
                                </td>
                                <td class="action-holder">
                                    <a href="" title="Open link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Work Title</b>
                                    <br>Date posted: Month XX, XXXX
                                </td>
                                <td>
                                    Category
                                </td>
                                <td>
                                    XXX
                                </td>
                                <td>
                                    XXX
                                </td>
                                <td class="action-holder">
                                    <a href="" title="Open link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection