# Python Background Removal API - VPS Setup Guide

This guide will help you set up and run the Python microservice on your Ubuntu VPS.

## 1. Install Prerequisites
SSH into your VPS and run the following commands to ensure Python and `pip` are installed:
```bash
sudo apt update
sudo apt install python3 python3-pip python3-venv -y
```

## 2. Setup Project
Upload the `python_api` folder to your VPS (for example, inside your Laravel project root: `/var/www/stationary-helper/python_api`).

Navigate to the directory:
```bash
cd /var/www/stationary-helper/python_api
```

## 3. Create a Virtual Environment and Install Dependencies
It's best practice to use a virtual environment for Python projects. Since we had dependency issues before, we will create a fresh one:

```bash
# Remove old broken virtual environment
rm -rf venv

# Create a fresh virtual environment
python3 -m venv venv

# Activate it
source venv/bin/activate

# Install the correct versions from the updated requirements.txt
pip install -r requirements.txt
```
*(Note: Installing `rembg` might take a few minutes as it downloads AI models in the background during first run).*

## 4. Test the API Manually
Run the server to see if it starts successfully:
```bash
uvicorn main:app --host 0.0.0.0 --port 8000
```
If you see "Application startup complete", press `Ctrl+C` to stop it. We will run it in the background next.

## 5. Run as a Background Service (systemd)
To ensure the API runs automatically when the server restarts, create a systemd service.

```bash
sudo nano /etc/systemd/system/bg-remover.service
```

Paste the following configuration (adjust the paths if your project is located elsewhere):
```ini
[Unit]
Description=Background Removal FastAPI Service
After=network.target

[Service]
User=root
Group=root
WorkingDirectory=/home/syfoocuv/public_html/importentapi/python_api
Environment="PATH=/home/syfoocuv/public_html/importentapi/python_api/venv/bin"
ExecStart=/home/syfoocuv/public_html/importentapi/python_api/venv/bin/uvicorn main:app --host 0.0.0.0 --port 8000
Restart=always

[Install]
WantedBy=multi-user.target
```

Save and exit (`Ctrl+O`, `Enter`, `Ctrl+X`).

## 6. Enable and Start the Service
```bash
sudo systemctl daemon-reload
sudo systemctl start bg-remover
sudo systemctl enable bg-remover
```

## 7. Check Status
To verify it's running:
```bash
sudo systemctl status bg-remover
```
Your API is now running locally on `http://127.0.0.1:8000` and Laravel can communicate with it!
