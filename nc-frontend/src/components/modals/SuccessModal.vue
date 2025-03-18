<template>
    <div class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Submission Details</h2>
          <button class="close-button" @click="closeModal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="details-container">
            <div class="details-heading">
              <span class="details-icon">📋</span>
              <p>Here are the details of your submission:</p>
            </div>
            <ul class="details-list">
              <li><strong>IGN:</strong> <span class="detail-value">{{ formData.ign }}</span></li>
              <li><strong>Class:</strong> <span class="detail-value">{{ formData.class }}</span></li>
              <li><strong>Level:</strong> <span class="detail-value">{{ formData.level }}</span></li>
              <li><strong>Power:</strong> <span class="detail-value">{{ formData.power }}</span></li>
              <li><strong>Discord:</strong> <span class="detail-value">{{ formData.discord }}</span></li>
              <li><strong>Member access code:</strong> <span class="detail-value">{{ formData.member_access_code }}</span></li>
            </ul>
          </div>
          <div class="instructions-container">
            <div class="instructions-heading">
              <span class="instructions-icon">📝</span>
              <h3>Instructions</h3>
            </div>
            <p class="instructions-text">{{ instructions }}</p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="primary-button" @click="closeModal">Acknowledge & Close</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    formData: {
      type: Object,
      required: true
    },
    instructions: {
      type: String,
      default: 'Please wait for further instructions from the guild master.'
    }
  });
  
  const emit = defineEmits(['close']);
  
  const closeModal = () => {
    emit('close');
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    backdrop-filter: blur(3px);
    transition: opacity 0.3s ease;
  }
  
  .modal-content {
    background: #fff;
    border-radius: 12px;
    max-width: 550px;
    width: 90%;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    transform: translateY(0);
    transition: transform 0.3s ease;
    animation: modal-appear 0.3s ease-out;
  }
  
  @keyframes modal-appear {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .modal-header {
    background: #10B981;
    color: white;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e9ecef;
  }
  
  .modal-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
  }
  
  .close-button {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    margin: 0;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
  }
  
  .close-button:hover {
    background-color: rgba(255, 255, 255, 0.2);
  }
  
  .modal-body {
    padding: 24px;
  }
  
  .modal-footer {
    padding: 16px 24px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    text-align: right;
  }
  
  .details-container, .instructions-container {
    margin-bottom: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
  }
  
  .details-heading, .instructions-heading {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
  }
  
  .details-icon, .instructions-icon {
    font-size: 1.3rem;
    margin-right: 8px;
  }
  
  .details-heading p {
    margin: 0;
    font-weight: 500;
    color: #333;
  }
  
  .instructions-heading h3 {
    margin: 0;
    font-weight: 600;
    color: #333;
  }
  
  .details-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }
  
  .details-list li {
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .details-list li:last-child {
    border-bottom: none;
  }
  
  .detail-value {
    color: #10B981;
    font-weight: 500;
  }
  
  .instructions-text {
    background: white;
    padding: 12px;
    border-radius: 6px;
    border-left: 4px solid #10B981;
    margin: 0;
    line-height: 1.5;
  }
  
  .primary-button {
    padding: 10px 24px;
    background: #10B981;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.2s, transform 0.1s;
  }
  
  .primary-button:hover {
    background: #0ea371;
  }
  
  .primary-button:active {
    transform: translateY(1px);
  }
  
  /* For mobile responsiveness */
  @media (max-width: 600px) {
    .modal-content {
      width: 95%;
      border-radius: 8px;
    }
    
    .modal-header {
      padding: 12px 16px;
    }
    
    .modal-body, .modal-footer {
      padding: 16px;
    }
    
    .details-list li {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .details-list li strong {
      margin-bottom: 4px;
    }
  }
  </style>