<template>
    <Teleport to="body">
      <Transition name="fade">
        <div 
          v-if="visible" 
          :class="[
            'toast-notification',
            `toast-notification--${type}`,
            position
          ]"
          @click="closeToast"
        >
          <div class="toast-notification__icon">
            <svg v-if="type === 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="15" y1="9" x2="9" y2="15"></line>
              <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
          </div>
          <div class="toast-notification__content">
            <div class="toast-notification__message">{{ message }}</div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits, onMounted, onBeforeUnmount } from 'vue';
  
  const props = defineProps({
    message: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: 'success',
      validator: (value) => ['success', 'fail'].includes(value)
    },
    duration: {
      type: Number,
      default: 3000
    },
    position: {
      type: String,
      default: 'top-right',
      validator: (value) => ['top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center'].includes(value)
    }
  });
  
  const emit = defineEmits(['close']);
  const visible = ref(false);
  let timer = null;
  
  onMounted(() => {
    visible.value = true;
    if (props.duration > 0) {
      timer = setTimeout(() => {
        closeToast();
      }, props.duration);
    }
  });
  
  onBeforeUnmount(() => {
    if (timer) {
      clearTimeout(timer);
    }
  });
  
  const closeToast = () => {
    visible.value = false;
    setTimeout(() => {
      emit('close');
    }, 300); // Wait for animation to complete
  };
  </script>
  
  <style scoped>
  .toast-notification {
    position: fixed;
    display: flex;
    align-items: center;
    min-width: 250px;
    max-width: 350px;
    padding: 12px 16px;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    cursor: pointer;
    z-index: 9999;
  }
  
  .toast-notification--success {
    background-color: #10B981;
    color: white;
  }
  
  .toast-notification--fail {
    background-color: #EF4444;
    color: white;
  }
  
  .toast-notification__icon {
    margin-right: 12px;
    flex-shrink: 0;
  }
  
  .toast-notification__content {
    flex-grow: 1;
  }
  
  .toast-notification__message {
    font-size: 14px;
    line-height: 1.5;
  }
  
  /* Positions */
  .top-right {
    top: 20px;
    right: 20px;
  }
  
  .top-left {
    top: 20px;
    left: 20px;
  }
  
  .bottom-right {
    bottom: 20px;
    right: 20px;
  }
  
  .bottom-left {
    bottom: 20px;
    left: 20px;
  }
  
  .top-center {
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
  }
  
  .bottom-center {
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
  }
  
  /* Fade animation */
  .fade-enter-active,
  .fade-leave-active {
    transition: all 0.3s ease;
  }
  
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
  }
  </style>