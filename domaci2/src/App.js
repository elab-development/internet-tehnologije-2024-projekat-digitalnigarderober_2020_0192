import logo from './logo.svg';
import './App.css';
import HomePage from './Komponente/HomePage';
import RegisterForm from './Komponente/RegisterForm';
import LoginForm from './Komponente/LoginForm';

function App() {
  return (
    <div className="App">
        <HomePage></HomePage>
        <RegisterForm></RegisterForm>
        <LoginForm></LoginForm>
    </div>
  );
}

export default App;
