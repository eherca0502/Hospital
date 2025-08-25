// Control básico de inicio de sesión y registro
document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Registrado correctamente!');
});

document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    document.getElementById('dashboard').style.display = 'block';
    alert('Sesión iniciada!');
});

// Lógica para añadir pacientes
let patients = [];
document.getElementById('addPatientForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let patientName = document.getElementById('patientName').value;
    let admissionDate = document.getElementById('admissionDate').value;
    let dischargeDate = document.getElementById('dischargeDate').value;

    let newPatient = {
        name: patientName,
        admissionDate: admissionDate,
        dischargeDate: dischargeDate
    };

    patients.push(newPatient);
    updatePatientList();
});

function updatePatientList() {
    let patientList = document.getElementById('patientList');
    patientList.innerHTML = '';

    patients.forEach((patient, index) => {
        let row = `
            <tr>
                <td>${patient.name}</td>
                <td>${patient.admissionDate}</td>
                <td>${patient.dischargeDate || 'N/A'}</td>
                <td>
                    <button onclick="deletePatient(${index})">Eliminar</button>
                </td>
            </tr>
        `;
        patientList.innerHTML += row;
    });
}

function deletePatient(index) {
    patients.splice(index, 1);
    updatePatientList();
}

// Lógica para añadir doctores
let doctors = [];
document.getElementById('addDoctorForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let doctorName = document.getElementById('doctorName').value;
    let specialty = document.getElementById('specialty').value;

    let newDoctor = {
        name: doctorName,
        specialty: specialty
    };

    doctors.push(newDoctor);
    updateDoctorList();
});

function updateDoctorList() {
    let doctorList = document.getElementById('doctorList');
    doctorList.innerHTML = '';

    doctors.forEach((doctor, index) => {
        let row = `
            <tr>
                <td>${doctor.name}</td>
                <td>${doctor.specialty}</td>
                <td>
                    <button onclick="deleteDoctor(${index})">Eliminar</button>
                </td>
            </tr>
        `;
        doctorList.innerHTML += row;
    });
}

function deleteDoctor(index) {
    doctors.splice(index, 1);
    updateDoctorList();
}
