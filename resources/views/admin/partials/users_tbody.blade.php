@foreach($users as $u)
  <tr>
    <td>{{ $u->name }}</td>
    <td>{{ $u->email }}</td>
    <td>
      @if($u->is_staff)
        <span class="badge published">موظف</span>
      @else
        <span class="badge draft">غير موظف</span>
      @endif
    </td>
    <td class="text-end">
      <div class="actions-vertical">
        @if(!$u->is_staff)
          <form method="post" action="{{ route('admin.users.promote') }}" onsubmit="return confirm('ترقية {{ $u->name }} إلى موظف؟')">
            @csrf
            <input type="hidden" name="email" value="{{ $u->email }}">
            <button class="btn btn-primary btn-sm" type="submit">ترقية لموظف</button>
          </form>
        @else
          <span class="text-muted" style="font-size:12px">لا إجراء</span>
        @endif
      </div>
    </td>
  </tr>
@endforeach
