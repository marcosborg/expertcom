<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>START DATE</th>
            <th>END DATE</th>
            <th>FLEET MANAGEMENT</th>
            <th>AMOUNT</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fleet_adjustments as $fleet_adjustment)
            <tr>
                <td>{{ $fleet_adjustment->id }}</td>
                <td>{{ $fleet_adjustment->name }}</td>
                <td>{{ $fleet_adjustment->start_date }}</td>
                <td>{{ $fleet_adjustment->end_date }}</td>
                <td>{{ $fleet_adjustment->company_id }}</td>
                <td>{{ $fleet_adjustment->amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>