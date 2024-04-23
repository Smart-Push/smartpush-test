import { render, screen, waitFor } from "@testing-library/react";
import TransactionDetails from "./TransactionDetails";

describe("TransactionDetails component", () => {
  
  beforeEach(() => {
    jest.spyOn(global, "fetch").mockImplementation(() =>
      Promise.resolve(
        new Response(
          JSON.stringify({
            id: 1,
            label: "Test Transaction",
            amount: 100,
          })
        )
      )
    );
  });

  afterEach(() => {
    jest.restoreAllMocks();
  });

  it("should display transaction details", async () => {
    render(<TransactionDetails transactionId={1} />);
    await waitFor(() => {
      expect(screen.getByText("Transaction details")).toBeInTheDocument();
    });
    await waitFor(() => {
      expect(screen.getByText("ID")).toBeInTheDocument();
    });
    await waitFor(() => {
      expect(screen.getByText("1")).toBeInTheDocument();
    });
    await waitFor(() => {
      expect(screen.getByText("Label")).toBeInTheDocument();
    });
    await waitFor(() => {
      expect(screen.getByText("Test Transaction")).toBeInTheDocument();
    });
    await waitFor(() => {
      expect(screen.getByText("Amount")).toBeInTheDocument();
    });
    await waitFor(() => {
      expect(screen.getByText("100")).toBeInTheDocument();
    });
  });

  it("should display error message if fetch fails", async () => {
    jest
      .spyOn(global, "fetch")
      .mockImplementation(() =>
        Promise.reject(new Error("Failed to fetch transaction details."))
      );
    render(<TransactionDetails transactionId={1} />);
    await waitFor(() => {
      expect(
        screen.getByText("Failed to fetch transaction details.")
      ).toBeInTheDocument();
    });
  });

  it("should not display transaction details if no transactionId is provided", async () => {
    render(<TransactionDetails />);
    expect(screen.queryByText("Transaction details")).not.toBeInTheDocument();
    expect(screen.queryByText("ID")).not.toBeInTheDocument();
    expect(screen.queryByText("Label")).not.toBeInTheDocument();
    expect(screen.queryByText("Amount")).not.toBeInTheDocument();
  });

});
