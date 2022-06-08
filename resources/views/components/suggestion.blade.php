<div class="my-2 shadow  text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $connection->name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ $connection->email }}</td>
      <td class="align-middle">
    </table>
    <div>
      <button id="create_request_btn_" onclick="sendRequest('{{ $user->id }}', '{{ $connection->id }}')" class="btn btn-primary me-1">Connect</button>
    </div>
  </div>
</div>
