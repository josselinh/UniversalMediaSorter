<form method="post" action="step-2.php">
    <fieldset>
        <legend>Main</legend>

        <label>
            Input directory :
            <input type="text" name="data[input][directory]" placeholder="Input directory" value="/home/josselin/Images/Dossier"/>
        </label>
    </fieldset>

    <fieldset>
        <legend>Masks</legend>

        <label>
            <input type="checkbox" name="data[input][masks][]" value="IMG_YYYYMMDD_HHMMSS.jpg" checked/>
            IMG_YYYYMMDD_HHMMSS.jpg
        </label>

        <br />

        <label>
            <input type="checkbox" name="data[input][masks][]" value="VID_YYYYMMDD_HHMMSS.mp4" checked/>
            VID_YYYYMMDD_HHMMSS.mp4
        </label>

        <br />

        <label>
            <input type="checkbox" name="data[input][masks][]" value="YYYYMMDD_HHMMSS.jpg" checked/>
            YYYYMMDD_HHMMSS.jpg
        </label>
        
        <br />
        
        <label>
            <input type="checkbox" name="data[input][masks][]" value="YYYY-MM-DD_HH-MM-SS_X.jpg" checked/>
            YYYY-MM-DD_HH-MM-SS_X.jpg
        </label>
    </fieldset>

    <button type="submit" name="submit" value="analyse">Analyse</button>
</form>