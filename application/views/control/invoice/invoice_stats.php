<thead>
            <tr>
                <th>&nbsp;</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>Hotels</td>
            <td><?=$stats['hotel']['amount']?> &euro;</td>
            <td><?=$stats['hotel']['paid']?> &euro;</td>
            <td><?=$stats['hotel']['status']?> &euro;</td>
        </tr>
        <tr>
            <td>Rundreise</td>
            <td><?=$stats['rundreise']['amount']?> &euro;</td>
            <td><?=$stats['rundreise']['paid']?> &euro;</td>
            <td><?=$stats['rundreise']['status']?> &euro;</td>
        </tr>
        <tr>
            <td>Transfer</td>
            <td><?=$stats['transfer']['amount']?> &euro;</td>
            <td><?=$stats['transfer']['paid']?> &euro;</td>
            <td><?=$stats['transfer']['status']?> &euro;</td>
        </tr>
        <tr>
            <td>Flights</td>
            <td><?=$stats['flight']['amount']?> &euro;</td>
            <td><?=$stats['flight']['paid']?> &euro;</td>
            <td><?=$stats['flight']['status']?> &euro;</td>
        </tr>
        <tr>
            <td>Other</td>
            <td><?=$stats['other']['amount']?> &euro;</td>
            <td><?=$stats['other']['paid']?> &euro;</td>
            <td><?=$stats['other']['status']?> &euro;</td>
        </tr>
        <tr class="total">
            <td>Total</td>
            <td><?=$stats['total']['amount']?> &euro;</td>
            <td><?=$stats['total']['paid']?> &euro;</td>
            <td><?=$stats['total']['status']?> &euro;</td>
        </tr>
        </tbody>