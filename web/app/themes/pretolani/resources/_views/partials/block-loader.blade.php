{{--
  Call each block associated blade file,
  giving block param as $fields var
--}}

@foreach ($blocks as $fields)
  @includeIf('blocks.' . $fields->__layout, [
    'fields' => $fields
  ])
@endforeach
