<div class="row mx-4 mt-3 justify-content-around">
    <div class="col-sm-12 col-md-6">
        <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
             aria-live="polite">{{ 'ردیف ' . $paginator->firstItem() . ' تا ' . $paginator->lastItem() . ' از ' . $paginator->total()}}
        </div>
    </div>
    <div class="col-sm-12 col-md-6 text-start">
        <div class="" id="DataTables_Table_0_paginate">
            <ul class="pagination text-start" dir="ltr">
                @if($paginator->hasMorePages())
                    <li class="paginate_button page-item next"
                        id="DataTables_Table_0_next"><a href="{{ $paginator->nextPageUrl() }}"
                                                        aria-controls="DataTables_Table_0"
                                                        data-dt-idx="next"
                                                        class="page-link">بعدی</a></li>
                @else
                    <li class="paginate_button page-item next"
                        id="DataTables_Table_0_next"><a href="#"
                                                        aria-controls="DataTables_Table_0"
                                                        data-dt-idx="next"
                                                        class="page-link">بعدی</a></li>
                @endif
                @if($paginator->onFirstPage())
                    <li class="paginate_button page-item next"
                        id="DataTables_Table_0_next"><a href="#"
                                                        aria-controls="DataTables_Table_0"
                                                        data-dt-idx="next"
                                                        class="page-link">قبلی</a></li>
                @else
                    <li class="paginate_button page-item next"
                        id="DataTables_Table_0_next">
                        <a href="{{ $paginator->previousPageUrl() }}"
                           aria-controls="DataTables_Table_0"
                           data-dt-idx="next"
                           class="page-link">قبلی</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
