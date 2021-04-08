<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#DeleteModel{{$id}}">
    {!! $btnText !!}
</button>
<div class="modal fade" id="DeleteModel{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center"  >
                <h3>هل انت متأكد</h3>
                <p>{{$message}}</p>
            </div>
            <form action="{{$url}}" method="post">
                @csrf @method('delete')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-primary">نعم حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>
