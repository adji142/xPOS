<script type="text/javascript">
	function BindLookupServices(TagName,KeyExpress,data,ColumnData) {
		var dataGridInstance = jQuery("#"+TagName).dxDataGrid({
			allowColumnResizing: true,
			dataSource: data,
			keyExpr: KeyExpress,
			showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 30
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            selection: {
                mode: "single" // Enable single selection mode
            },
            searchPanel: {
	            visible: true,
	            width: 240,
	            placeholder: "Search..."
	        },
	        columns: ColumnData

		});
	}
</script>