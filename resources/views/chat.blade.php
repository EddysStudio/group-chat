<!DOCTYPE html>
<html>
<head>
    <title>Групповой чат</title>    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('vendor/group-chat/main.css').'?'.time() }}"  rel="stylesheet"/>
    <script defer src="{{ asset('vendor/group-chat/alpine.min.js') }}"></script>
    <script src="{{ asset('vendor/group-chat/axios.min.js') }}"></script>
</head>
<body>    
    <div id="chat-container" x-data="chatForm()">
        <h1>Наш секретный чатик</h1>
        <div id="messages-wrp">
            <div id="messages">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="message-wrp">
                        <div class="message" :class="{ 'online': msg.user_online }">
                            <span class="author" x-text="msg.user_name || 'Anonim'"></span>:
                            <span class="text" x-text="msg.message"></span>
                            <span class="time" x-text="msg.created_at"></span>
                        </div>
                    </div>    
                </template>
            </div>
        </div>

        <form id="message-form" @submit.prevent="sendMessage">
            <textarea id="message-input"  x-model="message" placeholder="Ваше сообщение...">
            </textarea>    
            <button type="submit">Отправить</button>
        </form>
    </div>
    <script>
        function chatForm() {
            return {
                message: '',
                lastMessageId: 0, 
                messages: [],
                sending: false,
                csrfToken: '',
                timepass: Date.now(),
                timeout: 7000,
                timerId: null,

                init() {
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    this.csrfToken = meta ? meta.getAttribute('content') : '';
                    this.getMessages();
                    this.getStatuses();
                    setInterval(() => this.getStatuses(), 180000);
                },

                async getStatuses() {
                    try {
                        response = await fetch('/ourchat/statuses', {
                            headers: {
                                'Accept': 'application/json',
                            },
                        });
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }
                        const data = await response.json();
                        this.messages.map((item) => {
                            newItem = item;
                            if (data.users.indexOf(item.user_id) !== -1) newItem.user_online = true;
                                else newItem.user_online = false;
                            return newItem;
                        });
                    } catch (error) {
                        console.error('Ошибка загрузки сообщений:', error.message);
                    }    
                },
                
                async getMessages(last = 0) {
                    try {
                        lparam = '';
                        if(last>0) lparam = '?after='+last;
                        response = await fetch('/ourchat/messages'+lparam, {
                            headers: {
                                'Accept': 'application/json',
                            },
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        const data = await response.json();
                        if(last == 0) this.messages = data.messages;
                            else this.messages.push(...data.messages);
                        this.lastMessageId = this.messages[this.messages.length-1].id;
                    } catch (error) {
                        console.error('Ошибка загрузки сообщений:', error.message);
                    } finally {
                        // следующий вызов через 5 секунд
                        
                        if(this.timerId) clearTimeout(this.timerId);
                        // увеличим ожидание, если долго не пишешь
                        if(this.timepass < (Date.now()-120000)) this.timeout = 60000; 
                        this.timerId = setTimeout(
                            () => this.getMessages(this.lastMessageId), this.timeout
                        );
                    }
                },

                async sendMessage() {
                    const text = this.message.trim();
                    if (!text || this.sending) return;

                    this.sending = true;

                    try {
                        const response = await fetch('/ourchat/messages', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                            },
                            body: JSON.stringify({ message: text }),
                        });

                        if (!response.ok) {
                            // Если сервер вернул 422 (валидация) или 419 (CSRF)
                            const errorData = await response.json().catch(() => ({}));
                            throw new Error(errorData.message || `HTTP ${response.status}`);
                        } else {
                            const data = await response.json();
                            this.messages.push(data.message);
                            this.lastMessageId = data.message.id;
                            this.message = '';
                            
                            this.timepass = Date.now();
                            if(this.timerId) {
                                clearTimeout(this.timerId);
                                this.timeout = 7000;
                            }
                            this.timerId = setTimeout(
                                () => this.getMessages(this.lastMessageId), this.timeout
                            );
                        }                        
                        
                    } catch (error) {
                        console.error('Ошибка отправки:', error.response?.data || error.message);
                        alert('Не удалось отправить сообщение');
                    } finally {
                        this.sending = false;
                    }
                },
            };
        }
    </script>
</body>
</html>