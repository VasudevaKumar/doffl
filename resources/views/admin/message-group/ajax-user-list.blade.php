<li id="">
                                    <a href="javascript:void(0)" id=""
                                       onclick="showMessages('All Groups' , '0');">

                                       <img src="<?php echo url('/');?>/user-uploads/messagegroup/groupDiscussion.png" alt="msg-img"
                                                 class="img-circle">

                                        <span> All Groups
                                        </span>
                                    </a>
                                </li>
                            @forelse($messageGroups as $messagegroup)
                                <li id="">
                                    <a href="javascript:void(0)" id=""
                                       onclick="showMessages('{{$messagegroup->name}}' , {{$messagegroup->id}});">

                                       <img src="<?php echo url('/');?>/user-uploads/messagegroup/<?php echo $messagegroup->image;?>" alt="msg-img"
                                                 class="img-circle">

                                        <span> {{$messagegroup->name}}
                                        </span>
                                    </a>
                                </li>


                            @empty
                            @endforelse


                            <li class="p-20"></li>