<?php
function getStatusTypeColor($stato) {
    switch ($stato) {
        case 'Da Iniziare':
            return 'bg-secondary text-white'; // Grigio
        case 'In Corso':
            return 'bg-primary text-white'; // Blu
        case 'Completato':
            return 'bg-success text-white'; // Verde
        case 'In Pausa':
            return 'bg-warning text-dark'; // Giallo
        default:
            return 'bg-light text-dark'; // Default
    }
}
?>

<?php
function getStatusTypeIcon($stato) {
    switch ($stato) {
        case 'Da Iniziare':
            return '<i class="fas fa-circle text-white"></i>'; // Grigio
        case 'In Corso':
            return '<i class="fas fa-spinner text-white"></i>'; // Blu
        case 'Completato':
            return '<i class="fas fa-check-circle text-white"></i>'; // Verde
        case 'In Pausa':
            return '<i class="fas fa-pause-circle text-white"></i>'; // Giallo
        default:
            return '<i class="fas fa-sync-alt text-white"></i>'; // Default
    }
}
?>

