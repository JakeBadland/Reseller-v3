<!-- <script src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_MAPS_API_KEY&callback=initMap&v=weekly" defer></script> -->

<?= $this->extend('layouts/game'); ?>

<?= $this->section('puzzle'); ?>

<div class="puzzle-settings">
    <form id="form">
        <div class="form-row">
            <label>Файл:</label>
            <input type="file" name="file" accept="image/png, image/jpeg">
        </div>
        <div class="form-row">
            <label>По ширине:</label>
            <input type="text" name="cols" value="3">
        </div>
        <div class="form-row">
            <label>По высоте:</label>
            <input type="text" name="rows" value="3">
        </div>
        <div class="form-row">
            <input type="submit" value="Отправить">
        </div>
        <div class="form-row">
            <label id="status"></label>
        </div>
    </form>
</div>

<div class="puzzle-container">

</div>

<script type="application/javascript">
    $(document).ready(function(){

        $("#form").on('submit',(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/game/puzzle",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    $('#status').text('Sending');
                },
                success: function(data)
                {
                    if(data=='invalid')
                    {
                        $('#status').text('Invalid form data');
                    }
                    else
                    {
                        data = JSON.parse(data);
                        console.log(data.file_name);
                        $('#status').text('Uploaded');

                        $('.puzzle-container').prepend('<img src="'+data.file_name+'" />')
                    }
                },
                error: function(e)
                {
                    $('#status').html(e);
                }
            });
        }));


    });
</script>

<style>
    .form-row{
        margin-bottom: 6px;
    }
    .puzzle-settings{
        height: 250px;
        background-color: #FFFFFF;
        width: 80%;
        padding: 20px;
        margin: 20px auto 20px auto;
    }

    .puzzle-container{
        border: 5px solid white;
        width: 80%;
        height: 80vh;
        background-color: #1b6d85;
        margin: 0 auto;
        padding: 20px;
    }
</style>

<?= $this->endSection(); ?>