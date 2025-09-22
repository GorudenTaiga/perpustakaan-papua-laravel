import React from 'react';

export default function BukuList({ title, data }) {
  if (!data || !data.data) {
    return <div>No data available</div>;
  }

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">{title}</h1>
      <table className="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th className="py-2 px-4 border-b">Judul</th>
            <th className="py-2 px-4 border-b">Author</th>
            <th className="py-2 px-4 border-b">Publisher</th>
            <th className="py-2 px-4 border-b">Year</th>
            <th className="py-2 px-4 border-b">Stock</th>
            <th className="py-2 px-4 border-b">Price Per Day</th>
            <th className="py-2 px-4 border-b">Max Days</th>
            <th className="py-2 px-4 border-b">Category</th>
          </tr>
        </thead>
        <tbody>
          {data.data.length === 0 ? (
            <tr>
              <td colSpan="8" className="text-center py-4">
                No books found.
              </td>
            </tr>
          ) : (
            data.data.map((buku) => (
              <tr key={buku.id} className="text-center border-b">
                <td className="py-2 px-4">{buku.judul}</td>
                <td className="py-2 px-4">{buku.author}</td>
                <td className="py-2 px-4">{buku.publisher}</td>
                <td className="py-2 px-4">{buku.year}</td>
                <td className="py-2 px-4">{buku.stock}</td>
                <td className="py-2 px-4">{buku.price_per_day}</td>
                <td className="py-2 px-4">{buku.max_days}</td>
                <td className="py-2 px-4">{buku.category ? buku.category.nama : '-'}</td>
              </tr>
            ))
          )}
        </tbody>
      </table>
      {data.links && (
        <div className="mt-4">
          {data.links.map((link, index) => (
            <button
              key={index}
              className={`mx-1 px-3 py-1 border rounded ${
                link.active ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'
              }`}
              onClick={() => {
                if (link.url) {
                  window.location.href = link.url;
                }
              }}
              dangerouslySetInnerHTML={{ __html: link.label }}
            />
          ))}
        </div>
      )}
    </div>
  );
}
