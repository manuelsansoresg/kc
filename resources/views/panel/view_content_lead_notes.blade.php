@foreach ($notes as $result_note)
    @php
        $get_note = $result_note->note;
    @endphp
<div class="bq-note">
    <div class="bq-note-item">
        <div class="bq-note-text">
            <p> {{ $get_note->description }}</p>
        </div>
        <div class="bq-note-meta">
            <span class="bq-note-added">Agregado el <span
                    class="date">
                    {{ formatDateNameMonth($get_note->created_at) }}
                </span> </span>
            
        </div>
    </div><!-- .bq-note-item -->
</div><!-- .bq-note -->
@endforeach