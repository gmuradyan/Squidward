//Choose button
let inputs = document.querySelectorAll('.file-input')

for (var i = 0, len = inputs.length; i < len; i++) {
    customInput(inputs[i])
}

function customInput (el) {
    const fileInput = el.querySelector('[type="file"]')
    const label = el.querySelector('[data-js-label]')

    fileInput.onchange =
    fileInput.onmouseout = function () {
    if (!fileInput.value) return

    var value = fileInput.value.replace(/^.*[\\\/]/, '')
    el.className += ' -chosen'
    label.innerText = value
    }
}

//Process button
document.getElementById("processButton").onclick = () => {
    let fileElement = document.getElementById('fileInput')

    if (fileElement.files.length === 0) {
        Swal.fire({
            'text': 'Please choose a file',
            'confirmButtonColor': 'rgb(110 120 129 / 50%)',
        });
        return
    }

    let file = fileElement.files[0]
    let formData = new FormData();
    formData.set('file', file);

    axios.post("http://localhost/api/upload", formData, {
        onUploadProgress: progressEvent => {
            const percentCompleted = Math.round(
            (progressEvent.loaded * 100) / progressEvent.total
        )}
    }).then(res => {
        drawTable(res.data.data);
    }).catch(function (error) {
        const e = error.response.data.message;
        Swal.fire({
            'text': e,
            'confirmButtonColor': 'rgb(110 120 129 / 50%)',
        });
      });
}


// Drow Table
function drawTable(employees) {
    divtable.innerHTML = '';

    for (var r = 0; r < employees.length; r++) {
        var tbl = document.createElement("table");

        var thead = document.createElement("thead");
        thead.innerHTML = `<thead>
                                <tr>
                                <th><span>Employee</span></th>
                                <th><span>Employee</span></th>
                                <th><span>Score</span></th>
                                </tr>
                            </thead>`;
        tbl.appendChild(thead);

        average = employees[r].average;
        delete employees[r].average;

        Object.keys(employees[r]).forEach(function(key) {
            var row = document.createElement("tr");

            var e1 = employees[r][key]['employee1'];
            var e2 = employees[r][key]['employee2'];
            var score = employees[r][key]['score'];
            row.innerHTML = `<td>${e1}</td><td>${e2}</td><td>${score}</td>`;

            tbl.appendChild(row);
        });

        var row = document.createElement('tr');
        row.innerHTML = `<th colspan="2" bgcolor='' >Average Score</th><th>${average}</th>`
        tbl.appendChild(row);

        divtable.appendChild(tbl);
    }
}
