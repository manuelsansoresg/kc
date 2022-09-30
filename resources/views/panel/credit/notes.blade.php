@foreach ($notes as $row_note)
    @php
        $get_note = $row_note->note;
        $user = $get_note->userNote;
    @endphp
    <div class="bq-note">
        <div class="bq-note-item">
            <div class="bq-note-text">
                <p> {{ $get_note->description }}</p>
            </div>
            <div class="bq-note-meta text-end">
                <span class="bq-note-added">
                    {{ $user->name}} {{ $user->last_name}}
                    el <span class="date">
                        {{ formatDateNameMonth($get_note->created_at) }}
                    </span> </span>

            </div>
        </div><!-- .bq-note-item -->
    </div><!-- .bq-note -->
@endforeach
