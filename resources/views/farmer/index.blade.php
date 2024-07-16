<x-app-layout>
	<style>
	   
	</style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Farmer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" style="">
                    <label style="font-weight: bolder;">{{ __("List of farmer") }}</label>
            
                    <table id="grid-list" class="display table table-bordered table-responsive" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 30%;">ID</th>
                                <th style="width: 30%;">Name</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" style="">
                    <label style="font-weight: bolder;">{{ __("Transaction - farmer to pulper") }}</label>
            
                    <table id="grid-transaction" class="display table table-bordered table-responsive" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th style="width: 30%;">Name</th>
                                <th>Location</th>
                                <th>Item Type</th>
                                <th>Floating</th>
                                <th>Batch No.</th>
                                <th>Quantity</th>
                                <th>Purchase Price</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('javascript')
<script type="module">
    var start = 0;
    var limit = 10;
	$(document).ready(function() {

        $('#grid-list').DataTable( {
            'paging'      	: true,
        	'lengthChange'	: false,
        	'ordering'    	: false,
        	'info'        	: true,
        	'autoWidth'   	: false,
        	"processing"	: true,
        	"searching" 	: true,
        	"pageLength"	: limit,
			"ajax": {
				"url": "{{ route('farmer.list') }}",
				"data": function ( d ) {
					var info = $('#grid-list').DataTable().page.info();
					d.start = info.start;
					d.limit = limit;
				},
				"dataSrc": function(json){
					
					json.recordsTotal = json.data.docs.length;
					json.recordsFiltered = json.data.docs.length;

					return json.data.docs;
				}
			},
                            
			"columnDefs" : [
				{ "targets": 0, "data": "ID" },
				{ "targets": 1, "data": "FarmerName" },
				{ "targets": 2, "data": "Location" },
			]
		});

        $('#grid-transaction').DataTable( {
            'paging'      	: true,
        	'lengthChange'	: false,
        	'ordering'    	: false,
        	'info'        	: true,
        	'autoWidth'   	: false,
        	"processing"	: true,
        	"searching" 	: true,
        	"pageLength"	: limit,
			"ajax": {
				"url": "{{ route('farmer.transaction') }}",
				"data": function ( d ) {
					var info = $('#grid-transaction').DataTable().page.info();
					d.start = info.start;
					d.limit = limit;
				},
				"dataSrc": function(json){
					
					json.recordsTotal = json.data.docs.length;
					json.recordsFiltered = json.data.docs.length;

					return json.data.docs;
				}
			},
                            
			"columnDefs" : [
				{ "targets": 0, "data": "FarmerID" },
				{ "targets": 1, "data": "FarmerName" },
				{ "targets": 2, "data": "Location" },
				{ "targets": 3, "data": "ItemType" },
				{ "targets": 4, "data": "Floating" },
				{ "targets": 5, "data": "BatchNumber" },
				{ "targets": 6, "data": "Qty" },
				{ "targets": 7, "data": "PurchasePrice" },

			]
		});
	});

	function list(){
        
    	$.ajax({
        	url: "{{ route('farmer.list') }}",
        	data: {
        		_token			: "{{ csrf_token() }}",
            },
            type: 'get',
            
            async : true,
            success: function (response, textStatus, request) {
                console.log(response);
            },
            error: function (ajaxContext) {
            }
        });
    }
</script>
@endsection
</x-app-layout>