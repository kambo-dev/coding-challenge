<div class="my-2 shadow text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">
          @if($mode === 'sent')
              {{ $request->target?->name }}
          @elseif($mode === 'received')
              {{ $request->initiator?->name }}
          @endif
      </td>
      <td class="align-middle"> - </td>
      <td class="align-middle">
          @if($mode === 'sent')
              {{ $request->target?->email }}
          @elseif($mode === 'received')
              {{ $request->initiator?->email }}
          @endif
      </td>
      <td class="align-middle">
    </table>
    <div>
      @if ($mode == 'sent')
        <button id="cancel_request_btn_" class="btn btn-danger me-1"
          onclick="deleteRequest('{{ $request->target?->id }}', '{{ $request->id }}')">Withdraw Request</button>
      @else
        <button id="accept_request_btn_" class="btn btn-primary me-1"
          onclick="acceptRequest('{{ $request->initiator?->id }}', '{{ $request->id }}')">Accept</button>
      @endif
    </div>
  </div>
</div>
