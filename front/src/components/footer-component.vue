<script setup lang="ts">
import Email from './shared/email.vue'
import PhoneNumber from './shared/phone-number.vue'

const linksSocial = [
  {
    link: 'https://vk.com/iquest',
    img: 'vk.svg',
  },
  {
    link: 'https://t.me/questtomsk',
    img: 'telegram.svg',
  },
  {
    link: 'https://www.youtube.com/channel/UCiEXe3D9fy8GX9X73lpxOxA?disable_polymer=true',
    img: 'youtube.svg',
  },
]

const linkASAP = 'https://asapeducation.ru/?utm_course=iquest_site'
</script>

<template>
  <footer class="border">
    <div class="container footer">
      <img src="/logo/logo_full.svg" class="logo" alt="logo">
      <div class="footer-links">
        <div class="footer-links__contacts">
          <PhoneNumber />
          <Email />
        </div>
        <div class="footer-links__social">
          <a
            v-for="link in linksSocial"
            :key="link.img"
            target="_blank"
            :href="link.link"
          >
            <img :src="`/icons/social/${link.img}`" :alt="link.img">
          </a>
        </div>
      </div>
      <div class="footer-privacy">
        <p class="smallFootnote">
          Политика конфиденциальности
        </p>
        <span class="smallFootnote">
          Разработано в
          <a :href="linkASAP" target="_blank">
            <img src="/logo/asapLogo.svg" alt="asapLogo">
          </a>
        </span>
      </div>
    </div>
  </footer>
</template>

<style scoped lang="scss">
.border {
  border-top: 2px solid $color-shade-6 !important;
  background-image: url('/gradient/footer-gradient.svg');
  background-repeat: no-repeat;
  background-position: center top;
  margin-top: clamp(64px, 10vw, 108px);

  @media screen and (max-width: 1024px) {
    background-position: center 160px;
  }
}

.footer {
  height: 100%;
  margin-inline: auto;
  padding: clamp(32px, 3vw, 72px) clamp(16px, 3vw, 88px);
  justify-content: space-between;
  max-height: 282px;

  &-links {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    &__contacts {
      display: flex;
      flex-direction: column;
      gap: 12px;

      span {
        display: flex;
        gap: 8px;
      }
    }

    &__social {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }
  }

  &-privacy {
    justify-content: space-between;
    display: flex;
    flex-direction: column;
    align-items: flex-end;

    p {
      color: $color-base2;
    }

    span {
      color: #f0f0f0;
      display: flex;
      align-items: center;
      gap: 8px;
    }
  }

  @media screen and (max-width: 1024px) {
    display: grid;
    margin: 0 auto;
    grid-template-columns: 1fr;
    gap: 41px;
    max-height: 100%;

    &-links {
      grid-column: 1;
      grid-row: 1;
      align-items: center;
      gap: 41px;
      flex-direction: column-reverse;

      &__social {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;

        img {
          width: 100%;
          height: 32px;
        }

        a:nth-child(2) {
          grid-column: 3;
        }

        a:nth-child(3) {
          grid-row: 1;
          grid-column: 2;
        }
      }
    }

    &-privacy {
      grid-column: 1;
      grid-row: 3;
      align-items: center;
      gap: $cover-12;

      a {
        width: 80px;
        height: 40px;

        img {
          width: 100%;
        }
      }
    }

    .logo {
      max-width: 88px;
      width: 100%;
      padding-left: 18.5px;
      margin: 0 auto;
    }
  }
}
</style>
