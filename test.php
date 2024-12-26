<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Convert Excel to HTML Table using JavaScript</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container">
    	<h2 class="text-center mt-4 mb-4">Convert Excel to HTML Table using JavaScript</h2>
    	<div class="card">
    		<div class="card-header"><b>Select Excel File</b></div>
    		<div class="card-body">
                <input type="file" id="excel_file" onchange="test()"/>
    		</div>
    	</div>
        <div id="excel_data" class="mt-5"></div>
    </div>
</body>
</html>

<script>
function test(){
	var x = document.getElementById('excel_file');
	if(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(x.files[0].type)){
		var reader = new FileReader();
		reader.readAsArrayBuffer(x.files[0]); 
		alert("Allowed");
		reader.onload = function(event){
			var data = new Uint8Array(reader.result);
			var work_book = XLSX.read(data, {type:'array'});
			var sheet_name = work_book.SheetNames;
			var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});
			
			var startRow = '';
			var schidCol = '';
			var kinderCol = '';
			var oneCol = '';
			var twoCol = '';
			var threeCol = '';
			var fourCol = '';
			var fiveCol = '';
			var sixCol = '';
			
			//values
			var school_id = [];
			var kinderM = [];
			var kinderF = [];
			var oneM = [];
			var oneF = [];
			var twoM = [];
			var twoF = [];
			var threeM = [];
			var threeF = [];
			var fourM = [];
			var fourF = [];
			var fiveM = [];
			var fiveF = [];
			var sixM = [];
			var sixF = [];
			
			for(var row = 1; row <= sheet_data.length-1;row++){
				for(var col = 0; col <= sheet_data[row].length;col++){
					var headerName = sheet_data[row][col];
					switch(headerName){
						case "SCH. ID":
							schidCol = col;
							startRow = row+1;
							break;
						case "Kindergarten":
							kinderCol = col;
							break;
						case "Grade 1":
							oneCol = col;
							break;
						case "Grade 2":
							twoCol = col;
							break;
						case "Grade 3":
							threeCol = col;
							break;
						case "Grade 4":
							fourCol = col;
							break;
						case "Grade 5":
							fiveCol = col;
							break;
						case "Grade 6":
							sixCol = col;
							break;
							
					}
					if(parseInt(schidCol) == col && row > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							school_id.push(sheet_data[row][col])
						}
					}
					//KINDER
					if(parseInt(kinderCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							kinderM.push(sheet_data[row-1][col])
							kinderF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 1
					if(parseInt(oneCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							oneM.push(sheet_data[row-1][col])
							oneF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 2
					if(parseInt(twoCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							twoM.push(sheet_data[row-1][col])
							twoF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 2
					if(parseInt(twoCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							twoM.push(sheet_data[row-1][col])
							twoF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 3
					if(parseInt(threeCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							threeM.push(sheet_data[row-1][col])
							threeF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 4
					if(parseInt(fourCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							fourM.push(sheet_data[row-1][col])
							fourF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 5
					if(parseInt(fiveCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							fiveM.push(sheet_data[row-1][col])
							fiveF.push(sheet_data[row-1][col+1])
						}
					}
					//GRADE 6
					if(parseInt(sixCol) == col && row-1 > parseInt(startRow)){
						if(sheet_data[row][col] != null){
							sixM.push(sheet_data[row-1][col])
							sixF.push(sheet_data[row-1][col+1])
						}
					}
					
				} 
			}
			
			var table = '<table class="table table-bordered text-center">'+
			'<thead>'+
				'<tr>'+
					'<th rowspan="2">SCHOOL ID</th>'+
					'<th colspan="2">KINDER</th>'+
					'<th colspan="2">ONE</th>'+
					'<th colspan="2">TWO</th>'+
					'<th colspan="2">THREE</th>'+
					'<th colspan="2">FOUR</th>'+
					'<th colspan="2">FIVE</th>'+
					'<th colspan="2">SIX</th>'+
				'</tr>'+
				'<tr>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					'<th>MALE</th>'+
					'<th>FEMALE</th>'+
					
				'</tr>'+
			'</thead>'+
			'<tbody>';
			for(var z = 0;z <= school_id.length-1;z++){
				table = table+"<tr><td>"+school_id[z]+"</td>";
				table = table+"<td>"+kinderM[z]+"</td>";
				table = table+"<td>"+kinderF[z]+"</td>";
				table = table+"<td>"+oneM[z]+"</td>";
				table = table+"<td>"+oneF[z]+"</td>";
				table = table+"<td>"+twoM[z]+"</td>";
				table = table+"<td>"+twoF[z]+"</td>";
				table = table+"<td>"+threeM[z]+"</td>";
				table = table+"<td>"+threeF[z]+"</td>";
				table = table+"<td>"+fourM[z]+"</td>";
				table = table+"<td>"+fourF[z]+"</td>";
				table = table+"<td>"+fiveM[z]+"</td>";
				table = table+"<td>"+fiveF[z]+"</td>";
				table = table+"<td>"+sixM[z]+"</td>";
				table = table+"<td>"+sixF[z]+"</td></tr>";
			}
			table = table + "</tbody></div>";
			document.getElementById('excel_data').innerHTML = table;
		}
    }else{
		document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';
        excel_file.value = '';
        return false;
	}
	
}
// const excel_file = document.getElementById('excel_file');

// excel_file.addEventListener('change', (event) => {

    // if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
    // {
        // document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

        // excel_file.value = '';

        // return false;
    // }

    // var reader = new FileReader();

    // reader.readAsArrayBuffer(event.target.files[0]);

    // reader.onload = function(event){

        // var data = new Uint8Array(reader.result);

        // var work_book = XLSX.read(data, {type:'array'});

        // var sheet_name = work_book.SheetNames;

        // var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});

        // if(sheet_data.length > 0)
        // {
            // var table_output = '<table class="table table-striped table-bordered">';

            // for(var row = 0; row < sheet_data.length; row++)
            // {

                // table_output += '<tr>';

                // for(var cell = 0; cell < sheet_data[row].length; cell++)
                // {

                    // if(row == 0)
                    // {

                        // table_output += '<th>'+sheet_data[row][cell]+'</th>';

                    // }
                    // else
                    // {

                        // table_output += '<td>'+sheet_data[row][cell]+'</td>';

                    // }

                // }

                // table_output += '</tr>';

            // }

            // table_output += '</table>';

            // document.getElementById('excel_data').innerHTML = table_output;
        // }

        // excel_file.value = '';

    // }

// });

</script>