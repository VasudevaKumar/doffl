@forelse($messageDetails as $chatDetail)
    <li class="odd">

        <div class="chat-image">
            
                <img src="{{ asset('img/default-profile-3.png') }}" alt="user-img"
                     class="img-circle">
        </div>
        <div class="chat-body">
            <div class="chat-text">
                <p>{{ $chatDetail->messageText }}</p>
                <?php 
                if($chatDetail->filePath!='')
                    { ?>
                <p><a href="<?php echo url('/');?>/user-uploads/groupFiles/{{ $chatDetail->filePath}}"><?php echo url('/');?>/user-uploads/groupFiles/{{ $chatDetail->filePath}}</p>
                <?php } ?>

                <b>{{ $chatDetail->name}} - {{ $chatDetail->created_at}}</b>
            </div>
        </div>
    </li>

@empty
    <li><div class="message">@lang('messages.noMessage')</div></li>
@endforelse
