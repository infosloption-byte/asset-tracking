<style>
  table{
    font-size:8px;
  }
  .full-border{
    border: 1px solid #000;
  }
  .border{
    border-color: #000;
    border-style: solid;
  }
</style>
<img src="assets/sammy_new/images/invoice-header.jpg">
<span style="font-size: 12px"></span>

<div></div>
<div style="margin-bottom: 15px"></div>
<div style="margin-bottom: 15px"></div>

<table class="full-border" style="width: 100%">
    <thead>
      <tr style="background-color:#000;line-height: 2;">
          <th style="color:#fff;text-align: center;">#</th>
          <th style="color:#fff;text-align: center;">Asset SerialNo</th>
          <th style="color:#fff;text-align: center;">Inventory No</th>
          <th style="color:#fff;text-align: center;">Asset Location</th>
          <th style="color:#fff;text-align: center;">Asset Status</th>
          <th style="color:#fff;text-align: center;">Supplier</th>
          <th style="color:#fff;text-align: center;">Warranty Start</th>
          <th style="color:#fff;text-align: center;">Warranty End</th>
          <th style="color:#fff;text-align: center;">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1 ?>
      @foreach($data as $item)
          <tr style="height: 40px">
              <td>{{$i}}</td>
              <td style="text-align:center">{{$item->asset_no}}</a></td>
              <td style="text-align:center">{{$item->inventory_no}}</td>
              <td style="text-align:center"><span>{{$item->transaction[0]->location->name}}</span></td>
              <td style="text-align:center">
                   @if($item->transaction[0]->status->id==ASSET_UNDEPLOY)
                      <span class="badge" style="background-color: #dda30c;padding: 5px;color: white">{{$item->transaction[0]->status->name}}</span>
                  @elseif($item->transaction[0]->status->id==ASSET_DISPOSED)
                      <span class="badge" style="background-color: #dd1144;padding: 5px;color: white">{{$item->transaction[0]->status->name}}</span>
                  @elseif($item->transaction[0]->status->id==ASSET_INSERVICE)
                      <span class="badge" style="background-color: #74dd00;padding: 5px;color: white">{{$item->transaction[0]->status->name}}</span>
                  @elseif($item->transaction[0]->status->id==ASSET_DEPLOY)
                      <span class="badge" style="background-color: #3e3aff;padding: 5px;color: white">{{$item->transaction[0]->status->name}}</span>
                  @else
                      <span class="badge" style="">{{$item->transaction[0]->status->name}}</span>
                  @endif
              </td>
              <td style="text-align:center">{{$item->supplier->name}}</td>
              <td style="text-align:center">{{$item->warranty_from}}</td>
              <td style="text-align:center">{{$item->warranty_to}}</td>
              <td style="text-align:center"><span class="badge" style="background-color: #dd1144;padding: 5px;color: white">Expired</span></td>
              <?php $i++ ?>
          </tr>
      @endforeach
    </tbody>

</table>

<div></div>

<img style="bottom:0;" src="assets/sammy_new/images/invoice-footer.jpg">
