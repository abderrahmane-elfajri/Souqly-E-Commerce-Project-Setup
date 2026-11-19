import urllib.request
import urllib.parse
import http.cookiejar
import re
import sys

cj = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj))

BASE_URL = "http://127.0.0.1:8000"

def get_csrf_token(html):
    m = re.search(r'name="_token"\s+value="([^"]+)"', html)
    if m:
        return m.group(1)
    m = re.search(r'content="([^"]+)"\s+name="csrf-token"', html)
    if m:
        return m.group(1)
    return None

def check_url(name, path, expected_status=200):
    url = BASE_URL + path
    req = urllib.request.Request(url, headers={'User-Agent': 'SouqlyQA/1.0'})
    try:
        res = opener.open(req)
        html = res.read().decode('utf-8', errors='ignore')
        status = res.getcode()
        
        has_title = "<title>" in html
        has_viewport = 'name="viewport"' in html
        has_h1 = "<h1" in html
        has_wa = "wa.me" in html
        has_mad = "MAD" in html or "د.م." in html
        
        passed = (status == expected_status)
        flag = "OK" if passed else "MISMATCH"
        print(f"[{status}] {name:32} -> {flag} | Title:{has_title} | Viewport:{has_viewport} | H1:{has_h1} | WA:{has_wa} | MAD:{has_mad}")
        return passed, html
    except urllib.error.HTTPError as e:
        print(f"[{e.code}] {name:32} -> HTTP Error: {e.reason}")
        return False, str(e)
    except Exception as e:
        print(f"[ERR] {name:32} -> {e}")
        return False, str(e)

def login(email, password):
    # GET /login to get CSRF token
    req = urllib.request.Request(BASE_URL + "/login", headers={'User-Agent': 'SouqlyQA/1.0'})
    res = opener.open(req)
    html = res.read().decode('utf-8', errors='ignore')
    token = get_csrf_token(html)
    if not token:
        print(f"[AUTH ERROR] Could not find CSRF token on /login for {email}")
        return False
    
    post_data = urllib.parse.urlencode({
        '_token': token,
        'email': email,
        'password': password
    }).encode('utf-8')
    
    login_req = urllib.request.Request(
        BASE_URL + "/login",
        data=post_data,
        headers={'User-Agent': 'SouqlyQA/1.0', 'Content-Type': 'application/x-www-form-urlencoded'}
    )
    login_res = opener.open(login_req)
    redirect_url = login_res.geturl()
    return True

def logout():
    try:
        # GET home or any page to get csrf token
        req = urllib.request.Request(BASE_URL + "/", headers={'User-Agent': 'SouqlyQA/1.0'})
        res = opener.open(req)
        html = res.read().decode('utf-8', errors='ignore')
        token = get_csrf_token(html)
        if token:
            post_data = urllib.parse.urlencode({'_token': token}).encode('utf-8')
            logout_req = urllib.request.Request(
                BASE_URL + "/logout",
                data=post_data,
                headers={'User-Agent': 'SouqlyQA/1.0', 'Content-Type': 'application/x-www-form-urlencoded'}
            )
            opener.open(logout_req)
    except Exception as e:
        pass

print("=" * 80)
print(" SOUQLY E-COMMERCE PLATFORM — FULL SUITE AUDIT & CRAWL VERIFICATION")
print("=" * 80)

results = []

# SECTION 1: PUBLIC STOREFRONT
print("\n--- [1] PUBLIC STOREFRONT & CATALOG ---")
r, _ = check_url("Home Page", "/")
results.append(("Home Page", r))
r, _ = check_url("Catalog Page", "/shop")
results.append(("Catalog Page", r))
r, _ = check_url("Catalog Category: Watches", "/shop?category=luxury-watches")
results.append(("Catalog Category: Watches", r))
r, _ = check_url("Catalog Category: Electronics", "/shop?category=electronics")
results.append(("Catalog Category: Electronics", r))
r, _ = check_url("Product: Royal Chrono 41mm", "/product/souqly-royal-chrono-41mm")
results.append(("Product: Royal Chrono 41mm", r))
r, _ = check_url("Product: Heritage Classic Gold", "/product/souqly-heritage-classic-gold")
results.append(("Product: Heritage Classic Gold", r))
r, _ = check_url("Shopping Cart", "/cart")
results.append(("Shopping Cart", r))
r, _ = check_url("Checkout (Guest)", "/checkout")
results.append(("Checkout (Guest)", r))
r, _ = check_url("Order Tracking Portal", "/track")
results.append(("Order Tracking Portal", r))
r, _ = check_url("XML Sitemap", "/sitemap.xml")
results.append(("XML Sitemap", r))
r, _ = check_url("Robots.txt", "/robots.txt")
results.append(("Robots.txt", r))
r, _ = check_url("Login Form", "/login")
results.append(("Login Form", r))
r, _ = check_url("Register Form", "/register")
results.append(("Register Form", r))
r, _ = check_url("FAQ (Foire Aux Questions)", "/faq")
results.append(("FAQ", r))
r, _ = check_url("Shipping Policy (Maroc)", "/shipping-policy")
results.append(("Shipping Policy", r))
r, _ = check_url("Return Policy (Garantie 7j)", "/return-policy")
results.append(("Return Policy", r))
r, _ = check_url("Terms of Service (Loi 31-08)", "/terms")
results.append(("Terms of Service", r))
r, _ = check_url("Privacy Policy (CNDP)", "/privacy")
results.append(("Privacy Policy", r))
r, _ = check_url("Checkout Success Screen", "/checkout/success/SQL-202611-CAS01")
results.append(("Checkout Success", r))

# SECTION 2: ARABIC RTL LOCALIZATION
print("\n--- [2] TRILINGUAL & RTL LOCALIZATION ---")
opener.open(BASE_URL + "/locale/ar")
r, ar_html = check_url("Home Page (Arabic RTL)", "/")
results.append(("Home Page (Arabic RTL)", r))
is_rtl = 'dir="rtl"' in ar_html
has_cairo = 'Cairo' in ar_html
has_arabic_mad = 'د.م.' in ar_html
print(f"      -> RTL Attribute: {is_rtl} | Cairo Font: {has_cairo} | Arabic Currency (د.م.): {has_arabic_mad}")
results.append(("RTL Layout Check", is_rtl and has_cairo and has_arabic_mad))

# Switch to English
opener.open(BASE_URL + "/locale/en")
r, en_html = check_url("Home Page (English LTR)", "/")
results.append(("Home Page (English LTR)", r))
is_ltr = 'dir="ltr"' in en_html
print(f"      -> LTR Attribute: {is_ltr} | EN Tag: {'lang=\"en\"' in en_html}")

# Switch back to French (Default)
opener.open(BASE_URL + "/locale/fr")
r, fr_html = check_url("Home Page (French LTR)", "/")
results.append(("Home Page (French LTR)", r))

# SECTION 3: AUTHENTICATED CUSTOMER PORTAL
print("\n--- [3] CUSTOMER ACCOUNT PORTAL ---")
cj.clear() # clear cookies
login_ok = login("client@souqly.ma", "password123")
print(f"[AUTH] Login client@souqly.ma: {'SUCCESS' if login_ok else 'FAILED'}")
if login_ok:
    r, _ = check_url("Customer Dashboard", "/account")
    results.append(("Customer Dashboard", r))
    r, _ = check_url("Customer Orders List", "/account/orders")
    results.append(("Customer Orders List", r))
    r, _ = check_url("Customer Order Detail", "/account/orders/SQL-202611-CAS01")
    results.append(("Customer Order Detail", r))
    logout()

# SECTION 4: AUTHENTICATED ADMIN SUITE
print("\n--- [4] ADMINISTRATION SUITE ---")
cj.clear() # clear cookies
admin_ok = login("admin@souqly.ma", "password123")
print(f"[AUTH] Login admin@souqly.ma: {'SUCCESS' if admin_ok else 'FAILED'}")
if admin_ok:
    r, _ = check_url("Admin Overview / Dashboard", "/admin")
    results.append(("Admin Overview", r))
    r, _ = check_url("Admin Orders List", "/admin/orders")
    results.append(("Admin Orders List", r))
    r, _ = check_url("Admin Order Detail (#1)", "/admin/orders/1")
    results.append(("Admin Order Detail", r))
    r, _ = check_url("Admin Products Catalog", "/admin/products")
    results.append(("Admin Products Catalog", r))
    r, _ = check_url("Admin Create Product Screen", "/admin/products/create")
    results.append(("Admin Create Product Screen", r))
    r, _ = check_url("Admin Inventory & Stock Movements", "/admin/inventory")
    results.append(("Admin Inventory", r))
    r, _ = check_url("Admin Categories Management", "/admin/categories")
    results.append(("Admin Categories", r))
    r, _ = check_url("Admin Customers Directory", "/admin/customers")
    results.append(("Admin Customers", r))
    logout()

print("\n" + "=" * 80)
total_tests = len(results)
passed_tests = sum(1 for _, res in results if res)
print(f" AUDIT SUMMARY: {passed_tests}/{total_tests} CHECKS PASSED ({(passed_tests/total_tests)*100:.1f}%)")
print("=" * 80)
