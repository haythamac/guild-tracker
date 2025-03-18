import { ref, h, render } from 'vue';
import ToastNotification from '../components/ToastNotification.vue';

export function useToast() {
  const toasts = ref([]);
  let toastCount = 0;

  const createToast = (options) => {
    const id = `toast-${toastCount++}`;
    
    const vnode = h(ToastNotification, {
      ...options,
      onClose: () => removeToast(id)
    });
    
    const container = document.createElement('div');
    container.id = id;
    document.body.appendChild(container);
    render(vnode, container);
    
    toasts.value.push({ id, container });
    
    return id;
  };
  
  const removeToast = (id) => {
    const index = toasts.value.findIndex(toast => toast.id === id);
    if (index !== -1) {
      render(null, toasts.value[index].container);
      document.body.removeChild(toasts.value[index].container);
      toasts.value.splice(index, 1);
    }
  };
  
  const success = (message, options = {}) => {
    return createToast({
      message,
      type: 'success',
      ...options
    });
  };
  
  const fail = (message, options = {}) => {
    return createToast({
      message,
      type: 'fail',
      ...options
    });
  };
  
  return {
    success,
    fail,
    removeToast
  };
}