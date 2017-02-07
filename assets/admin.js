;( function( $ ) {
    function confirmBeforeDeletingAllBarks() {
        var confirm = window.confirm( 'This action will delete all barks currently stored in the database. Are you sure you wish to continue?' );

        if ( true === confirm ) {
            window.location = window.location.href + '&deleteAllBarks=1';
        }
    }

    function addClearAllBarksBtn() {
        var $addNewBtn = $( document.querySelector( '.page-title-action' ) ),
            $clearAllBarksBtn = $addNewBtn.clone()
                .attr( 'href', '#' )
                .text( 'Delete All Barks' );

        $clearAllBarksBtn.click( confirmBeforeDeletingAllBarks );
        $addNewBtn.after( $clearAllBarksBtn );
    }

    $( document ).ready( addClearAllBarksBtn );
} )( jQuery );
