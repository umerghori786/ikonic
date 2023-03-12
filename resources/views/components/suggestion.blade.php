<div id="skeleton_toggle" class="d-none">
  <x-skeleton />
</div>
<div class="ajax-suggestions">
@forelse($userSuggestions as $userSuggestion)

<div class="my-2 shadow  text-white bg-dark p-1 " id="connection_row_hide_{{$userSuggestion->id}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$userSuggestion->name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$userSuggestion->email}}</td>
      <td class="align-middle"> 
    </table>
    <div>
      <button id="create_request_btn_" class="btn btn-primary me-1" onclick="sentConnect(`{{$userSuggestion->id}}`)">Connect</button>
    </div>
  </div>
</div>

@empty
@endforelse
</div>
