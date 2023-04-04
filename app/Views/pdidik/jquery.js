function _load() {
  $.ajax({
    url: "<?= base_url('/pd/viewdata'); ?>",
    dataType: "json",
    success: function(response) {
      $(".viewpd").html(response.data);
      $("#tablepd").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        processing: true,
        aoColumnDefs: [
          {
            bSortable: false,
            aTargets: ["no-short"]
          }
        ]
      });

      $(".detail").click(function() {
        $.ajax({
          url: $(this).data("link"),
          type: "post",
          data: {
            id: $(this).data("id")
          },
          dataType: "json",
          success: function(view) {
            $(".detailview").html(view.data);
            $("#detailview").modal("show");
          }
        });
      });
    }
  });
}

$(document).ready(function() {
  _load();
});
