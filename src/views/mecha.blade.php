
@if (isset($skip))
@include('mecha::partials.js_and_css')
@endif

<div id="moe-wrapper">

<table id="moeditor" class="table table-bordered" data-resizable-columns-id="moeditor-table">
<thead>
  <tr>
    <th data-resizable-column-id="tree-controls">@include('mecha::tree_controls')</th>
    <th data-resizable-column-id="editor-controls">@include('mecha::controls')</th>
  </tr>
</thead>
<tbody>
 <tr>
    <td class="tree-td tree-dark">@include('mecha::tree')</td>
    <td class="tree-td tree-dark" style="padding: 0px;">@include('mecha::editor')</td>
 </tr>
</tbody>
</table>

<div>