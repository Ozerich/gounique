<table class="product-list finanzen-list" id="previewstats-list">
    <thead>
    <tr>
        <th>BG-ART</th>
        <th>Anzahl</th>
        <th>Persons</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="type">Pauschalreise</td>
        <td><?=$type_stats['pausschalreise']['count']?></td>
        <td><?=$type_stats['pausschalreise']['persons']?></td>
        <td><?=num($type_stats['pausschalreise']['total'])?></td>
    </tr>
    <tr>
        <td class="type">Bausteinreise</td>
        <td><?=$type_stats['bausteinreise']['count']?></td>
        <td><?=$type_stats['bausteinreise']['persons']?></td>
        <td><?=num($type_stats['bausteinreise']['total'])?></td>
    </tr>
    <tr>
        <td class="type">Nur Flug</td>
        <td><?=$type_stats['nurflug']['count']?></td>
        <td><?=$type_stats['nurflug']['persons']?></td>
        <td><?=num($type_stats['nurflug']['total'])?></td>
    </tr>
    <tr class="total">
        <td class="type">Total</td>
        <td><?=$type_stats['pausschalreise']['count'] + $type_stats['bausteinreise']['count'] + $type_stats['nurflug']['count']?></td>
        <td><?=$type_stats['pausschalreise']['persons'] + $type_stats['bausteinreise']['persons'] + $type_stats['nurflug']['persons']?></td>
        <td><?=num($type_stats['pausschalreise']['total'] + $type_stats['bausteinreise']['total'] + $type_stats['nurflug']['total'])?></td>
    </tr>
    </tbody>
</table>