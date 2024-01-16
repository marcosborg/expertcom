<table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>start_date</th>
        <th>end_date</th>
        <th>type</th>
        <th>fleet_management</th>
        <th>driver</th>
        <th>company</th>
        <th>amount</th>
    </tr>
    @foreach ($fleet_adjustments as $fleet_adjustment)
    <tr>
        <td>{{ $fleet_adjustment->id }}</td>
        <td>{{ $fleet_adjustment->name }}</td>
        <td>{{ $fleet_adjustment->start_date }}</td>
        <td>{{ $fleet_adjustment->end_date }}</td>
        <td>{{ $fleet_adjustment->type }}</td>
        <td>{{ $fleet_adjustment->fleet_management }}</td>
        <td>{{ $fleet_adjustment->driver }}</td>
        <td>{{ \App\Models\Company::find($fleet_adjustment->company_id)->name }}</td>
        <td>{{ $fleet_adjustment->type == 'refund' ? '-' : '' }}{{ $fleet_adjustment->amount }}</td>
    </tr>
    @endforeach
</table>