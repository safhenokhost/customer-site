# انتشار customer-site روی GitHub (کنار saas-platform)

این پروژه زیرمجموعهٔ **saas-platform** است و از پنل اصلی مدیریت می‌شود. برای قرار دادن آن روی GitHub کنار پروژهٔ اصلی:

## ۱. ساخت ریپوزیتوری جدید روی GitHub

1. وارد [GitHub](https://github.com) شوید.
2. روی **New repository** (یا از منو **+** → New repository) کلیک کنید.
3. نام ریپو را مثلاً **customer-site** بگذارید (یا هر نامی که دوست دارید).
4. توضیح اختیاری: `سایت مشتری - زیرمجموعهٔ saas-platform`
5. **Public** یا **Private** را انتخاب کنید.
6. **تیک "Add a README" را نزنید** (الان خود پروژه README دارد).
7. روی **Create repository** کلیک کنید.

## ۲. اتصال پروژهٔ محلی به GitHub و پوش کردن

در ترمینال، داخل پوشهٔ **customer-site** این دستورات را بزنید (به‌جای `USERNAME` نام کاربری گیت‌هاب و به‌جای `customer-site` در صورت تفاوت، نام ریپو را بگذارید):

```bash
cd c:\laragon\www\customer-site

# اگر قبلاً remote دیگری داشتید و می‌خواهید فقط origin را برای GitHub بگذارید:
git remote remove origin   # فقط در صورت وجود origin قبلی

# اضافه کردن ریپو گیت‌هاب به عنوان origin
git remote add origin https://github.com/USERNAME/customer-site.git

# ارسال شاخهٔ main به GitHub
git push -u origin main
```

اگر ریپوی گیت‌هاب را با نام دیگری ساخته‌اید (مثلاً `my-customer-site`)، به‌جای `customer-site` در آدرس از همان نام استفاده کنید:

```text
https://github.com/USERNAME/my-customer-site.git
```

## ۳. بعد از اولین پوش

از این به بعد برای آپدیت کردن کد روی GitHub کافی است:

```bash
cd c:\laragon\www\customer-site
git add .
git commit -m "توضیح تغییرات"
git push
```

---

**نکته:** اگر از SSH استفاده می‌کنید، به‌جای آدرس `https://...` از آدرس SSH استفاده کنید، مثلاً:

```text
git@github.com:USERNAME/customer-site.git
```

بعد از این، هر دو ریپو **saas-platform** و **customer-site** در اکانت/سازمان گیت‌هاب شما کنار هم قرار می‌گیرند.
