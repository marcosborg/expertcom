<table>
    <tr style="text-align: left;">
        <th>id</th>
        <th>name</th>
        <th>amount</th>
        <th>driver</th>
        <th>company_id</th>
    </tr>
    @foreach ($fleet_adjustments as $fleet_adjustment)
        <tr>
            <td>{{ $fleet_adjustment->id }}</td>
            <td>{{ $fleet_adjustment->name }}</td>
            <td>{{ $fleet_adjustment->type == 'refund' ? '-' : '' }}{{ $fleet_adjustment->amount }}</td>
            <td>{{ $fleet_adjustment->driver_name }}</td>
            <td>{{ \App\Models\Company::find($fleet_adjustment->company_id)->name }}</td>
        </tr>
    @endforeach
</table>