 $(function()
 {
    $users_list = $('#users_list');
    $users_list.multiselect({
        listWidth: 870
    });

    $("#submit_data").click(function( e ) {
        var fields = $( ":input" ).serializeArray();
        $( "#results" ).empty().append( JSON.stringify( fields , null, "\t") );
    });

 });