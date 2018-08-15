<script type="text/javascript">
var business_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#business_table');

        var settings = {
            responsive: true,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 8, "desc" ]
            ],

            columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
						return `
                        <span class="dropdown">
                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/edit_option/`+data+`"><i class="la la-leaf"></i> Edit Option</a>
                            </div>
                        </span>
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                          <i class="la la-edit"></i>
                        </a>`;
					},
				},
                {
                    targets: -4,
                    render: function(data, type, full, meta) {
                        var status = {
                            0: {'title': 'Hide', 'class': ' m-badge--warning'},
                            1: {'title': 'Show', 'class': 'm-badge--success'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
			],
        };

        business_data_table = table.dataTable(settings);
    }

    initTableWithDynamicRows();

})(window.jQuery);

</script>