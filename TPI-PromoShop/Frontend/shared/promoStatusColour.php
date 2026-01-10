<?php
$statusClasses = [
    PromoStatus_enum::Pendiente->value => 'badge-warning',
    PromoStatus_enum::Aprobada->value  => 'badge-primary',
    PromoStatus_enum::Vigente->value   => 'badge-success',
    PromoStatus_enum::Rechazada->value => 'badge-danger',
    PromoStatus_enum::Vencida->value   => 'badge-secondary',
];
?>
