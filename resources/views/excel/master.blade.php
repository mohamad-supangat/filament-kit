<?php

$thead_style = " align='center' height='25' style='border: 1px solid #000000; background: {$template->color}; color: " . ($darkColor ? '#ffffff' : '#000000') . "; font-weight:bold;' valign='center' width='30' ";

$example_style = " valign='top' height='60' style='border: 1px solid #000000; background: #E7EAFF; color: #000000' ";

?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
        <tr>
            @foreach ($template->columns as $column)
                <th {!! $thead_style !!}>{!! $column['name'] !!}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                @foreach ($template->columns as $column)
                    <td>{{ $column->render($row) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</html>
