<x-app-layout>
	<style>

	</style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Puller') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" style="">
                    <label style="font-weight: bolder;">{{ __("List of pulper") }}</label>
            
                    <table id="grid-list" class="display table table-bordered table-responsive" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 30%;">ID</th>
                                <th style="width: 30%;">Name</th>
                                <th>Lat Long Location</th>
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
                    <label style="font-weight: bolder;">{{ __("Transaction - pulper to huller") }}</label>
            
                    <table id="grid-transaction" class="display table table-bordered table-responsive" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10%;">Batch No.</th>
                                <th>PO Number</th>
                                <th>VCH Code</th>
                                <th>VCH Delivery Date</th>
                                <th>VCH Delivery No.</th>
                                <th>VCH Item Qty</th>
                                <th>VCP Code</th>
                                <th>VCP Finish Process Date</th>
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
				"url": "{{ route('pulper.location') }}",
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
				{ "targets": 1, "data": "Name" },
				{ "targets": 2, "data": "latitude",
						"render": function ( data, type, row, meta ) {
                            return row.Latitude+", "+row.Longitude;
                        }
                },
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
        	"scrollX"		: true,
			"ajax": {
				"url": "{{ route('pulper.transaction') }}",
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
				{ "targets": 0, "data": "BatchNumber" },
				{ "targets": 1, "data": "PoNumber" },
				{ "targets": 2, "data": "VchCode" },
				{ "targets": 3, "data": "VchDeliveryDate" },
				{ "targets": 4, "data": "VchDeliveryNumber" },
				{ "targets": 5, "data": "VchItemQty" },
				{ "targets": 6, "data": "VcpCode" },
				{ "targets": 7, "data": "VcpFinishProcessDate" },

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