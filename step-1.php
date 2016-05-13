<form method="post" action="step-2.php">
    <fieldset>
        <legend>Main</legend>

        <label>
            Input directory :
            <input type="text" name="data[directory][input]" placeholder="Input directory" value="/home/josselin/Images/Dossier"/>
        </label>
        
        <br />
        
        <label>
            Output directory :
            <input type="text" name="data[directory][output]" placeholder="Output directory" value="/home/josselin/Images/Sorted"/>
        </label>
    </fieldset>

    <fieldset>
        <legend>Masks</legend>

        <label>
            <input type="checkbox" name="data[masks][]" value="IMG_YYYYMMDD_HHIISS.jpg" checked/>
            IMG_YYYYMMDD_HHIISS.jpg
        </label>

        <br />
        
        <label>
            <input type="checkbox" name="data[masks][]" value="IMG_DDMMYYYY_HHIISS.jpg" checked/>
            IMG_DDMMYYYY_HHIISS.jpg
        </label>

        <br />

        <label>
            <input type="checkbox" name="data[masks][]" value="VID_YYYYMMDD_HHIISS.mp4" checked/>
            VID_YYYYMMDD_HHIISS.mp4
        </label>

        <br />

        <label>
            <input type="checkbox" name="data[masks][]" value="YYYYMMDD_HHIISS.jpg" checked/>
            YYYYMMDD_HHIISS.jpg
        </label>
        
        <br />
        
        <label>
            <input type="checkbox" name="data[masks][]" value="YYYY-MM-DD_HH-II-SS_X.jpg" checked/>
            YYYY-MM-DD_HH-II-SS_X.jpg
        </label>
        
        <br />
        
        <label>
            <input type="checkbox" name="data[masks][]" value="YYYY/MM/DD/IMG_YYYYMMDD_HHIISS.jpg" checked/>
            YYYY/MM/DD/IMG_YYYYMMDD_HHIISS.jpg
        </label>
        
        <br />
        <br />
        
        <label>
            Add :
            <input type="text" name="data[masks][]" value="IMAGE_YYYYMMDD_HHIISS.jpg"/>
    </fieldset>
    
    <br />

    <button type="submit" name="submit" value="analyse">Analyse</button>
</form>