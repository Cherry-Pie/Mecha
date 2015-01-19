   

    @if (!in_array('jquery.js', $skip))
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    @endif

    @if (!in_array('jquery-ui.js', $skip))
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    @endif

    @if (!in_array('bootstrap.css', $skip))
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    @endif

    @if (!in_array('jquery-ui.css', $skip))
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    @endif

    @if (!in_array('bootstrap-theme.css', $skip))
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    @endif

    @if (!in_array('font-awesome.css', $skip))
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    @endif


    @if (!in_array('toastr.js', $skip))
    <script src="/packages/yaro/mecha/toastr/toastr.min.js"></script>
    @endif

    @if (!in_array('toastr.css', $skip))
    <link  href="/packages/yaro/mecha/toastr/toastr.min.css" rel="stylesheet">
    @endif





    <link  href="{{ asset('/packages/yaro/mecha/rescol/jquery.resizableColumns.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('/packages/yaro/mecha/rescol/jquery.resizableColumns.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/packages/yaro/mecha/rescol/store.js') }}" type="text/javascript"></script>
    

    <script src="{{ asset('/packages/yaro/mecha/jtree/jqueryFileTree.js') }}" type="text/javascript"></script>
    <link  href="{{ asset('/packages/yaro/mecha/jtree/jqueryFileTree.css') }}" rel="stylesheet" type="text/css" media="screen" />
    
    <script src="{{ asset('/packages/yaro/mecha/jquery-contextMenu/jquery.contextMenu.js') }}" type="text/javascript"></script>
    <link  href="{{ asset('/packages/yaro/mecha/jquery-contextMenu/jquery.contextMenu.css') }}" rel="stylesheet" type="text/css" media="screen" />

    <script src="{{ asset('/packages/yaro/mecha/pack/mecha.js') }}"></script>
    <script src="{{ asset('/packages/yaro/mecha/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('/packages/yaro/mecha/ace/ext-modelist.js') }}" type="text/javascript" charset="utf-8"></script>



    <link  href="{{ asset('/packages/yaro/mecha/pack/main.css') }}" rel="stylesheet">
    <link  href="{{ asset('/packages/yaro/mecha/pack/mecha.css') }}" rel="stylesheet">