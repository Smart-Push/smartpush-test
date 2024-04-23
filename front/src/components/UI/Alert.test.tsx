import { render, screen } from "@testing-library/react";
import Alert from "./Alert";

describe('Alert component', () => {

  test("renders with the provided text", () => {
    const text = "Sample Error Text";
    render(<Alert text={text} />);
    expect(screen.getByText(text)).toBeInTheDocument();
  })

});
