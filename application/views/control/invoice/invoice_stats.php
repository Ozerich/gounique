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
            <td><?=num($stats['hotel']['amount'])?> &euro;</td>
            <td><?=num($stats['hotel']['paid'])?> &euro;</td>
            <td><?=num($stats['hotel']['status'])?> &euro;</td>
        </tr>
        <tr>
            <td>Rundreise</td>
            <td><?=num($stats['rundreise']['amount'])?> &euro;</td>
            <td><?=num($stats['rundreise']['paid'])?> &euro;</td>
            <td><?=num($stats['rundreise']['status'])?> &euro;</td>
        </tr>
        <tr>
            <td>Transfer</td>
            <td><?=num($stats['transfer']['amount'])?> &euro;</td>
            <td><?=num($stats['transfer']['paid'])?> &euro;</td>
            <td><?=num($stats['transfer']['status'])?> &euro;</td>
        </tr>
        <tr>
            <td>Other</td>
            <td><?=num($stats['other']['amount'])?> &euro;</td>
            <td><?=num($stats['other']['paid'])?> &euro;</td>
            <td><?=num($stats['other']['status'])?> &euro;</td>
        </tr>
        <tr class="total">
            <td>Reisepreis</td>
            <td><?=num($stats['total']['amount'])?> &euro;</td>
            <td><?=num($stats['total']['paid'])?> &euro;</td>
            <td><?=num($stats['total']['status'])?> &euro;</td>
        </tr>
        </tbody>