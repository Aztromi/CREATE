<section>
    <h1>Connect with Creatives List</h1>
    <hr>
    
    <div class="table-responsive mt-60 mb-60">

    

    <table id="table-connect-with-creatives" class="table table-white table-hover">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Date Requested</th>
                <th>Action/s</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>
                        <div class="requester_name">{{ $request->name }}</div>
                        <span class="requester_type {{ $request->type }}">
                            {{ $request->type }}
                        </span>
                    </td>
                    <td>{{ $request->statusText }}</td>
                    <td>
                        <div hidden>{{ $request->date_requested }}</div>
                        <div class="w-100">{{ $request->date_requested->isToday() ? 'Today' : \Carbon\Carbon::parse($request->date_requested)->format('F d, Y') }}</div>
                        <div class="w-100">{{ \Carbon\Carbon::parse($request->date_requested)->format('h:i a') }}</div>
                    </td>


                    <td style="vertical-align: middle;">
                        @if($request->status == 0)
                            <a href="{{ route('admin.connect-creative.response', ['id' => $request->id]) }}" title="Respond"><i class="fa fa-reply"></i></a>
                        {{--
                        @elseif(in_array($request->status, [1,2]))
                            <a href="" title="View"><i class="fa fa-external-link"></i></a>
                        --}}
                        @endif
                    </td>


                </tr>
            @endforeach
        </tbody>
        

        <!-- <tfoot>
        <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        </tr>
        </tfoot> -->
    </table>

    </div>
</section>