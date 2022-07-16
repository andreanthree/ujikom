<div class="row">
  <div class="col-12">
    <div class="card">
      @if(isset($card_header) && $card_header == 'true')
      <div class="card-header p-b-3 @isset($card_header_class) {{ $card_header_class }} @endisset">
        {!! $card_header_content !!}
      </div>
      @endif
      <div class="card-body">
        <div class="row">
          <div class="col-md-9"></div>
        {{-- @isset($buttons)
          <div id="buttons" class="col-md-9 buttons @isset($buttons_class) {{ $buttons_class }} @endisset">
            {{ $buttons }}
          </div>
        @endisset --}}
        @isset($buttons)
          <div id="buttons" class="col-md-3 buttons @isset($buttons_class) {{ $buttons_class }} @endisset text-right" style="float: right;">
            {{ $buttons }}
          </div>
        @endisset
        </div>
        
        <div class="table-responsive">
          <table class="table table-bordered w-100" data-scroll-y="400" style="overflow: auto;" id="{{ $table_id }}">
            <thead>
              {{ $table_header }}
            </thead>
            @isset($table_body)
            <tbody id="table_body_{{ $table_id }}">
                {{$table_body}}
            </tbody>
            @endisset
            
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@push('after-style')
  @include('includes.datatables-styles')
@endpush

@push('after-script')
  @include('includes.datatables-scripts')

  <script>
    $.extend(true, $.fn.dataTable.defaults, {
      columnDefs: {
        targets: '_all',
        defaultContent: '-'
      },
      stateSave: true,
      scrollX: true,
      scrollCollapse: true,
      language: {
        url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
      },
    });
  </script>

@endpush